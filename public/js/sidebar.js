document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".role-option").forEach((item) => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            const role = this.dataset.role;
            const userId = this.dataset.id ?? null;

            fetch(window.SET_ACTIVE_USER_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.CSRF_TOKEN,
                },
                body: JSON.stringify({
                    id: this.dataset.id,
                    role: role,
                    user_id: userId,
                }),
            })
                .then((res) => res.json())
                .then(() => location.reload());
        });
    });
});
