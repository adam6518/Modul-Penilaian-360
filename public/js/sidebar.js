document.addEventListener("DOMContentLoaded", function () {
    async function setActiveUser(role, userId = null) {
        try {
            const response = await fetch(window.SET_ACTIVE_USER_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": window.CSRF_TOKEN,
                },
                body: JSON.stringify({
                    role: role,
                    user_id: userId,
                }),
            });

            if (!response.ok) {
                throw new Error("Gagal mengubah pengguna.");
            }

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.message || "Pengguna gagal diubah.");
            }

            window.location.reload();
        } catch (error) {
            console.error("Pergantian pengguna gagal:", error);
            alert(
                error.message ||
                    "Tidak dapat mengubah pengguna. Silakan coba lagi.",
            );
        }
    }

    document.querySelectorAll(".role-option").forEach((item) => {
        item.addEventListener("click", function (event) {
            event.preventDefault();

            const role = this.dataset.role;
            const userId = this.dataset.id || null;

            setActiveUser(role, userId);
        });
    });

    const mobileRoleSelect = document.getElementById("mobileRoleSelect");
    const mobileRoleApply = document.getElementById("mobileRoleApply");

    if (mobileRoleSelect && mobileRoleApply) {
        mobileRoleApply.addEventListener("click", function () {
            const selectedValue = mobileRoleSelect.value;

            if (selectedValue === "admin") {
                setActiveUser("admin");
            } else {
                setActiveUser("user", selectedValue);
            }
        });
    }
});
