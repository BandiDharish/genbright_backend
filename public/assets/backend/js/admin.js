document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("adminSidebar");
    const toggleButton = document.getElementById("adminSidebarToggle");
    const overlay = document.getElementById("adminSidebarOverlay");

    function openSidebar() {
        sidebar?.classList.add("active");
        overlay?.classList.add("active");
        document.body.classList.add("admin-sidebar-open");
    }

    function closeSidebar() {
        sidebar?.classList.remove("active");
        overlay?.classList.remove("active");
        document.body.classList.remove("admin-sidebar-open");
    }

    toggleButton?.addEventListener("click", function () {
        if (sidebar?.classList.contains("active")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    overlay?.addEventListener("click", closeSidebar);

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeSidebar();
        }
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 991) {
            closeSidebar();
        }
    });


    /*
    |--------------------------------------------------------------------------
    | Profile Dropdown & Modals JavaScript
    |--------------------------------------------------------------------------
    */

    const profileTrigger = document.getElementById("adminProfileTrigger");
    const profileMenu = document.getElementById("adminProfileMenu");
    const profileModal = document.getElementById("profileModal");
    const settingsModal = document.getElementById("settingsModal");

    const openProfileBtn = document.getElementById("openProfileBtn");
    const openSettingsBtn = document.getElementById("openSettingsBtn");
    const switchToSettingsBtn = document.getElementById("switchToSettingsBtn");
    const settingsForm = document.getElementById("profileSettingsForm");
    const saveSettingsBtn = document.getElementById("saveSettingsBtn");
    const settingsFormError = document.getElementById("settingsFormError");

    // Toggle Dropdown
    profileTrigger?.addEventListener("click", function (event) {
        event.stopPropagation();
        const isOpen = profileMenu?.classList.contains("show");
        if (isOpen) {
            closeProfileDropdown();
        } else {
            profileTrigger.classList.add("active");
            profileTrigger.setAttribute("aria-expanded", "true");
            profileMenu?.classList.add("show");
        }
    });

    function closeProfileDropdown() {
        profileTrigger?.classList.remove("active");
        profileTrigger?.setAttribute("aria-expanded", "false");
        profileMenu?.classList.remove("show");
    }

    // Close Dropdown on clicking outside
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".admin-profile-dropdown")) {
            closeProfileDropdown();
        }
    });

    // Close modals helper
    function closeAllModals() {
        document.querySelectorAll(".admin-modal").forEach(function (modal) {
            modal.classList.remove("active");
        });
        document.body.style.overflow = "";

        // Reset validation error styling when closing settings form
        if (settingsForm) {
            settingsForm.reset();
            clearValidationErrors();
        }
    }

    function openModal(modal) {
        closeAllModals();
        closeProfileDropdown();
        if (modal) {
            modal.classList.add("active");
            document.body.style.overflow = "hidden";
        }
    }

    // Open Profile Modal
    openProfileBtn?.addEventListener("click", function (event) {
        event.preventDefault();
        openModal(profileModal);
    });

    // Open Settings Modal
    openSettingsBtn?.addEventListener("click", function (event) {
        event.preventDefault();
        openModal(settingsModal);
    });

    // Switch from Profile to Settings
    switchToSettingsBtn?.addEventListener("click", function () {
        openModal(settingsModal);
    });

    // Close buttons binding
    document.querySelectorAll("[data-close-modal]").forEach(function (button) {
        button.addEventListener("click", function () {
            closeAllModals();
        });
    });

    // Close modal on Escape key
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeAllModals();
        }
    });

    function clearValidationErrors() {
        if (settingsFormError) {
            settingsFormError.classList.add("d-none");
            settingsFormError.textContent = "";
        }
        settingsForm?.querySelectorAll(".form-control-custom").forEach(function (input) {
            input.classList.remove("is-invalid");
        });
        settingsForm?.querySelectorAll(".error-msg").forEach(function (span) {
            span.textContent = "";
        });
    }

    // Form validation and AJAX submission
    settingsForm?.addEventListener("submit", function (event) {
        event.preventDefault();
        clearValidationErrors();

        // Check if passwords match before sending
        const newPassword = document.getElementById("settingsNewPassword")?.value;
        const confirmPassword = document.getElementById("settingsConfirmPassword")?.value;

        if (newPassword && newPassword !== confirmPassword) {
            const confirmInput = document.getElementById("settingsConfirmPassword");
            confirmInput?.classList.add("is-invalid");
            const confirmError = document.getElementById("error-new_password_confirmation");
            if (confirmError) {
                confirmError.textContent = "The new password confirmation does not match.";
            }
            return;
        }

        saveSettingsBtn.disabled = true;
        const originalText = saveSettingsBtn.innerHTML;
        saveSettingsBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

        const formData = new FormData(settingsForm);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

        fetch(settingsForm.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json",
                "X-CSRF-TOKEN": csrfToken
            }
        })
        .then(async function (response) {
            const data = await response.json();

            if (response.ok && data.success) {
                if (typeof toastr !== "undefined") {
                    toastr.success(data.message || "Profile updated successfully.", "Success");
                } else {
                    alert(data.message || "Profile updated successfully.");
                }

                // Update email displays in UI
                const newEmail = data.user.email;
                const emailHeader = document.getElementById("dropdownMenuEmail");
                const emailDisplay = document.getElementById("profileEmailDisplay");
                const emailInput = document.getElementById("settingsEmail");

                if (emailHeader) emailHeader.textContent = newEmail;
                if (emailDisplay) emailDisplay.textContent = newEmail;
                if (emailInput) emailInput.value = newEmail;

                closeAllModals();
            } else {
                // Handling validations or errors
                if (response.status === 422 && data.errors) {
                    Object.keys(data.errors).forEach(function (key) {
                        const errorMsg = data.errors[key][0];
                        const errorSpan = document.getElementById("error-" + key);
                        const inputElement = settingsForm.querySelector(`[name="${key}"]`);

                        if (errorSpan) {
                            errorSpan.textContent = errorMsg;
                        }
                        if (inputElement) {
                            inputElement.classList.add("is-invalid");
                        }
                    });
                } else {
                    const errorMsg = data.message || "An error occurred. Please try again.";
                    if (settingsFormError) {
                        settingsFormError.textContent = errorMsg;
                        settingsFormError.classList.remove("d-none");
                    }
                }
            }
        })
        .catch(function (error) {
            console.error("Settings update error:", error);
            if (typeof toastr !== "undefined") {
                toastr.error("Unable to update settings. Please check your internet connection.", "Network Error");
            } else {
                alert("Network Error: Unable to update settings.");
            }
        })
        .finally(function () {
            saveSettingsBtn.disabled = false;
            saveSettingsBtn.innerHTML = originalText;
        });
    });
});

