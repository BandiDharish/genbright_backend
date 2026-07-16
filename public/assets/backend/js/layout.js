'use strict';

/*
|--------------------------------------------------------------------------
| Admin Layout JavaScript
|--------------------------------------------------------------------------
| Common JavaScript for all admin CRUD pages:
|
| - Close alerts
| - Delete records with SweetAlert and AJAX
| - Image preview
| - Drag-and-drop image upload
| - Character counter
| - Submit loading state
| - Image modal
| - YouTube preview link
| - Status option selection
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {
    initCrudAlerts();
    initCrudDelete();
    initCrudImageUpload();
    initCrudCharacterCounters();
    initCrudSubmitLoaders();
    initCrudImageModals();
    initCrudYoutubePreview();
    initCrudStatusOptions();
});


/*
|--------------------------------------------------------------------------
| Alert close
|--------------------------------------------------------------------------
*/

function initCrudAlerts() {
    const closeButtons = document.querySelectorAll('.crud-alert-close');

    if (!closeButtons.length) {
        return;
    }

    closeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const alert = button.closest('.crud-alert');

            if (!alert) {
                return;
            }

            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';

            window.setTimeout(function () {
                alert.remove();
            }, 200);
        });
    });
}


/*
|--------------------------------------------------------------------------
| Delete confirmation and AJAX request
|--------------------------------------------------------------------------
|
| Required delete-button attributes:
|
| data-crud-delete
| data-delete-url="..."
| data-delete-row="row-id"
| data-delete-title="Record title"
|--------------------------------------------------------------------------
*/

function initCrudDelete() {
    const deleteButtons = document.querySelectorAll('[data-crud-delete]');

    if (!deleteButtons.length) {
        return;
    }

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', async function () {
            if (button.disabled) {
                return;
            }

            const confirmed = await showCrudDeleteConfirmation(button);

            if (!confirmed) {
                return;
            }

            await deleteCrudRecord(button);
        });
    });
}


async function showCrudDeleteConfirmation(button) {
    const title =
        button.dataset.deleteTitle ||
        button.dataset.heading ||
        'this record';

    if (typeof Swal === 'undefined') {
        return window.confirm(
            'Are you sure you want to delete "' + title + '"?'
        );
    }

    const result = await Swal.fire({
        title: 'Delete Record?',
        html: `
            <p>
                Are you sure you want to delete
                <strong>${escapeCrudHtml(title)}</strong>?
            </p>

            <small>This action cannot be undone.</small>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText:
            '<i class="fas fa-trash-alt"></i> Delete',
        cancelButtonText:
            '<i class="fas fa-times"></i> Cancel',
        reverseButtons: true,
        focusCancel: true,
        allowOutsideClick: false,
        allowEscapeKey: true,
        buttonsStyling: false,
        customClass: {
            popup: 'crud-swal-popup',
            actions: 'crud-swal-actions',
            confirmButton:
                'crud-swal-btn crud-swal-confirm',
            cancelButton:
                'crud-swal-btn crud-swal-cancel'
        }
    });

    return result.isConfirmed;
}


async function deleteCrudRecord(button) {
    const deleteUrl =
        button.dataset.deleteUrl ||
        button.dataset.url;

    const rowId =
        button.dataset.deleteRow ||
        button.dataset.row;

    if (!deleteUrl) {
        showCrudError(
            'Delete Error',
            'The delete URL is missing.'
        );

        return;
    }

    const csrfToken = getCrudCsrfToken();

    if (!csrfToken) {
        showCrudError(
            'Security Error',
            'CSRF token was not found.'
        );

        return;
    }

    button.disabled = true;

    showCrudLoading(
        'Deleting...',
        'Please wait while the record is being deleted.'
    );

    try {
        const response = await fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await parseCrudResponse(response);

        if (!response.ok || data.success === false) {
            throw new Error(
                data.message ||
                'Failed to delete the record.'
            );
        }

        const isLastRow = removeCrudRow(rowId, button);

        await showCrudSuccess(
            'Deleted Successfully',
            data.message || 'The record was deleted successfully.'
        );

        if (isLastRow) {
            window.location.reload();
        }
    } catch (error) {
        console.error('CRUD delete error:', error);

        button.disabled = false;

        await showCrudError(
            'Unable to Delete',
            error.message ||
            'Something went wrong. Please try again.'
        );
    }
}


function removeCrudRow(rowId, button) {
    let row = null;

    if (rowId) {
        row = document.getElementById(rowId);
    }

    if (!row) {
        row = button.closest('tr');
    }

    if (!row) {
        return true;
    }

    row.classList.add('crud-row-removing');

    const remainingRows = document.querySelectorAll(
        '.crud-table tbody tr:not(.crud-empty-row)'
    );

    const isLastRow = (remainingRows.length <= 1);

    window.setTimeout(function () {
        row.remove();
        if (!isLastRow && !document.querySelectorAll('.crud-table tbody tr:not(.crud-empty-row)').length) {
            window.location.reload();
        }
    }, 300);

    return isLastRow;
}


/*
|--------------------------------------------------------------------------
| Image upload, validation, preview and drag-drop
|--------------------------------------------------------------------------
|
| Required elements:
|
| input:
| data-crud-image-input
|
| upload container:
| data-crud-upload-area
|
| preview wrapper:
| data-crud-preview-box
|
| preview image:
| data-crud-preview-image
|
| remove button:
| data-crud-remove-image
|--------------------------------------------------------------------------
*/

function initCrudImageUpload() {
    const imageInputs = document.querySelectorAll(
        '[data-crud-image-input]'
    );

    if (!imageInputs.length) {
        return;
    }

    imageInputs.forEach(function (input) {
        const group =
            input.closest('[data-crud-image-group]') ||
            input.closest('.crud-form-group') ||
            document;

        const uploadArea = group.querySelector(
            '[data-crud-upload-area]'
        );

        const previewBox = group.querySelector(
            '[data-crud-preview-box]'
        );

        const previewImage = group.querySelector(
            '[data-crud-preview-image]'
        );

        const removeButton = group.querySelector(
            '[data-crud-remove-image]'
        );

        input.addEventListener('change', function () {
            const file = input.files[0];

            if (!file) {
                clearCrudImagePreview(
                    input,
                    uploadArea,
                    previewBox,
                    previewImage
                );

                return;
            }

            validateAndPreviewCrudImage(
                file,
                input,
                uploadArea,
                previewBox,
                previewImage
            );
        });

        removeButton?.addEventListener('click', function () {
            clearCrudImagePreview(
                input,
                uploadArea,
                previewBox,
                previewImage
            );
        });

        if (!uploadArea) {
            return;
        }

        ['dragenter', 'dragover'].forEach(function (eventName) {
            uploadArea.addEventListener(eventName, function (event) {
                event.preventDefault();
                event.stopPropagation();

                uploadArea.classList.add('is-dragging');
            });
        });

        ['dragleave', 'drop'].forEach(function (eventName) {
            uploadArea.addEventListener(eventName, function (event) {
                event.preventDefault();
                event.stopPropagation();

                uploadArea.classList.remove('is-dragging');
            });
        });

        uploadArea.addEventListener('drop', function (event) {
            const file = event.dataTransfer.files[0];

            if (!file) {
                return;
            }

            try {
                const transfer = new DataTransfer();

                transfer.items.add(file);

                input.files = transfer.files;
            } catch (error) {
                console.warn(
                    'Unable to assign dropped file:',
                    error
                );
            }

            validateAndPreviewCrudImage(
                file,
                input,
                uploadArea,
                previewBox,
                previewImage
            );
        });
    });
}


function validateAndPreviewCrudImage(
    file,
    input,
    uploadArea,
    previewBox,
    previewImage
) {
    const allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    const maximumSize = 5 * 1024 * 1024;

    if (!allowedTypes.includes(file.type)) {
        if (typeof toastr !== 'undefined') {
            toastr.error('Select a JPG, JPEG, PNG or WEBP image.', 'Invalid Image');
        } else {
            alert('Invalid Image: Select a JPG, JPEG, PNG or WEBP image.');
        }

        clearCrudImagePreview(
            input,
            uploadArea,
            previewBox,
            previewImage
        );

        return;
    }

    if (file.size > maximumSize) {
        if (typeof toastr !== 'undefined') {
            toastr.error('The image must not exceed 5 MB.', 'Image Too Large');
        } else {
            alert('Image Too Large: The image must not exceed 5 MB.');
        }

        clearCrudImagePreview(
            input,
            uploadArea,
            previewBox,
            previewImage
        );

        return;
    }

    if (!previewBox || !previewImage) {
        return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {
        previewImage.src = event.target.result;
        previewBox.hidden = false;

        uploadArea?.classList.add('has-file');
    };

    reader.onerror = function () {
        if (typeof toastr !== 'undefined') {
            toastr.error('The selected image could not be previewed.', 'Preview Error');
        } else {
            alert('Preview Error: The selected image could not be previewed.');
        }

        clearCrudImagePreview(
            input,
            uploadArea,
            previewBox,
            previewImage
        );
    };

    reader.readAsDataURL(file);
}


function clearCrudImagePreview(
    input,
    uploadArea,
    previewBox,
    previewImage
) {
    if (input) {
        input.value = '';
    }

    if (previewImage) {
        previewImage.src = '';
    }

    if (previewBox) {
        previewBox.hidden = true;
    }

    uploadArea?.classList.remove(
        'has-file',
        'is-dragging'
    );
}


/*
|--------------------------------------------------------------------------
| Character counters
|--------------------------------------------------------------------------
|
| Input:
| data-crud-counter-input
|
| Counter:
| data-crud-counter
|
| Both should have matching data-counter-key values.
|--------------------------------------------------------------------------
*/

function initCrudCharacterCounters() {
    const inputs = document.querySelectorAll(
        '[data-crud-counter-input]'
    );

    if (!inputs.length) {
        return;
    }

    inputs.forEach(function (input) {
        const counterKey = input.dataset.counterKey;

        let counter = null;

        if (counterKey) {
            counter = document.querySelector(
                `[data-crud-counter="${cssEscape(counterKey)}"]`
            );
        }

        if (!counter) {
            const group = input.closest('.crud-form-group');

            counter = group?.querySelector(
                '[data-crud-counter]'
            );
        }

        if (!counter) {
            return;
        }

        const updateCounter = function () {
            counter.textContent = input.value.length;
        };

        updateCounter();

        input.addEventListener('input', updateCounter);
    });
}


/*
|--------------------------------------------------------------------------
| Form submit loading state
|--------------------------------------------------------------------------
|
| Form:
| data-crud-form
|
| Submit button:
| data-crud-submit
| data-loading-text="Saving..."
|--------------------------------------------------------------------------
*/

function initCrudSubmitLoaders() {
    const forms = document.querySelectorAll('[data-crud-form]');

    if (!forms.length) {
        return;
    }

    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const submitButton = form.querySelector(
                '[data-crud-submit]'
            );

            if (!submitButton) {
                return;
            }

            if (
                typeof form.checkValidity === 'function' &&
                !form.checkValidity()
            ) {
                return;
            }

            if (submitButton.disabled) {
                event.preventDefault();
                return;
            }

            submitButton.disabled = true;

            const loadingText =
                submitButton.dataset.loadingText ||
                'Saving...';

            submitButton.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                <span>${escapeCrudHtml(loadingText)}</span>
            `;
        });
    });
}


/*
|--------------------------------------------------------------------------
| Image modal
|--------------------------------------------------------------------------
|
| Preview trigger:
| data-crud-modal-image="image-url"
| data-crud-modal-title="Image title"
|
| Modal:
| data-crud-image-modal
|
| Modal image:
| data-crud-modal-preview
|
| Modal title:
| data-crud-modal-heading
|
| Close button:
| data-crud-modal-close
|--------------------------------------------------------------------------
*/

function initCrudImageModals() {
    const modal = document.querySelector(
        '[data-crud-image-modal]'
    );

    if (!modal) {
        return;
    }

    const modalImage = modal.querySelector(
        '[data-crud-modal-preview]'
    );

    const modalHeading = modal.querySelector(
        '[data-crud-modal-heading]'
    );

    const closeButtons = modal.querySelectorAll(
        '[data-crud-modal-close]'
    );

    const triggers = document.querySelectorAll(
        '[data-crud-modal-image]'
    );

    if (!modalImage || !triggers.length) {
        return;
    }

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const imageUrl =
                trigger.dataset.crudModalImage;

            const imageTitle =
                trigger.dataset.crudModalTitle || '';

            if (!imageUrl) {
                return;
            }

            modalImage.src = imageUrl;
            modalImage.alt = imageTitle;

            if (modalHeading) {
                modalHeading.textContent = imageTitle;
            }

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    closeButtons.forEach(function (button) {
        button.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape' &&
            modal.classList.contains('active')
        ) {
            closeModal();
        }
    });

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';

        window.setTimeout(function () {
            modalImage.src = '';

            if (modalHeading) {
                modalHeading.textContent = '';
            }
        }, 200);
    }
}


/*
|--------------------------------------------------------------------------
| YouTube preview link
|--------------------------------------------------------------------------
|
| Input:
| data-crud-youtube-input
|
| Link:
| data-crud-youtube-link
|--------------------------------------------------------------------------
*/

function initCrudYoutubePreview() {
    const inputs = document.querySelectorAll(
        '[data-crud-youtube-input]'
    );

    if (!inputs.length) {
        return;
    }

    inputs.forEach(function (input) {
        const group =
            input.closest('.crud-form-group') ||
            document;

        const previewLink = group.querySelector(
            '[data-crud-youtube-link]'
        );

        if (!previewLink) {
            return;
        }

        const updateLink = function () {
            const value = input.value.trim();

            previewLink.href = isSafeHttpUrl(value)
                ? value
                : '#';

            previewLink.classList.toggle(
                'disabled',
                !isSafeHttpUrl(value)
            );

            previewLink.setAttribute(
                'aria-disabled',
                isSafeHttpUrl(value)
                    ? 'false'
                    : 'true'
            );
        };

        updateLink();

        input.addEventListener('input', updateLink);

        previewLink.addEventListener('click', function (event) {
            if (
                previewLink.classList.contains('disabled')
            ) {
                event.preventDefault();
            }
        });
    });
}


/*
|--------------------------------------------------------------------------
| Status option cards
|--------------------------------------------------------------------------
|
| Status option:
| data-crud-status-option
|--------------------------------------------------------------------------
*/

function initCrudStatusOptions() {
    const options = document.querySelectorAll(
        '[data-crud-status-option]'
    );

    if (!options.length) {
        return;
    }

    options.forEach(function (option) {
        const radio = option.querySelector(
            'input[type="radio"]'
        );

        if (radio?.checked) {
            option.classList.add('active');
        }

        option.addEventListener('click', function () {
            const name = radio?.name;

            if (!name) {
                return;
            }

            document.querySelectorAll(
                `[data-crud-status-option] input[name="${cssEscape(name)}"]`
            ).forEach(function (input) {
                input
                    .closest('[data-crud-status-option]')
                    ?.classList.remove('active');
            });

            option.classList.add('active');

            if (radio) {
                radio.checked = true;
            }
        });
    });
}


/*
|--------------------------------------------------------------------------
| Shared helpers
|--------------------------------------------------------------------------
*/

function getCrudCsrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');
}


async function parseCrudResponse(response) {
    const contentType =
        response.headers.get('content-type') || '';

    if (!contentType.includes('application/json')) {
        if (response.ok) {
            return {
                success: true
            };
        }

        return {
            success: false,
            message:
                'The server returned an invalid response.'
        };
    }

    try {
        return await response.json();
    } catch (error) {
        return {
            success: false,
            message:
                'The server response could not be read.'
        };
    }
}


function showCrudLoading(title, message) {
    if (typeof Swal === 'undefined') {
        return;
    }

    Swal.fire({
        title: title,
        text: message,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: function () {
            Swal.showLoading();
        }
    });
}


async function showCrudSuccess(title, message) {
    if (typeof Swal === 'undefined') {
        window.alert(message);
        return;
    }

    await Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        confirmButtonText: 'Done'
    });
}


async function showCrudError(title, message) {
    if (typeof Swal === 'undefined') {
        window.alert(message);
        return;
    }

    await Swal.fire({
        title: title,
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}


function escapeCrudHtml(value) {
    const element = document.createElement('div');

    element.textContent = String(value || '');

    return element.innerHTML;
}


function cssEscape(value) {
    if (
        window.CSS &&
        typeof window.CSS.escape === 'function'
    ) {
        return window.CSS.escape(value);
    }

    return String(value).replace(
        /["\\]/g,
        '\\$&'
    );
}


function isSafeHttpUrl(value) {
    if (!value) {
        return false;
    }

    try {
        const url = new URL(
            value,
            window.location.origin
        );

        return (
            url.protocol === 'http:' ||
            url.protocol === 'https:'
        );
    } catch (error) {
        return false;
    }
}