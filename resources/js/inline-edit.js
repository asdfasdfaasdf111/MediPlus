document.addEventListener("DOMContentLoaded", () => {
    // Handle "Edit" button click
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            const button = e.currentTarget;              
            // kalo e.target yang diambil elemen paling dalam yang diklik langsung,
            // ubah jadi e.currentTarget biar ambil elemen btn yang dipasang event listener (<button class="edit-btn"> atau <button class="save-btn">)
            const row = button.closest("tr");
            row.querySelectorAll(".view-field").forEach(el => el.classList.add("d-none"));
            row.querySelectorAll(".edit-field").forEach(el => el.classList.remove("d-none"));
            row.querySelector(".edit-btn").classList.add("d-none");
            row.querySelector(".save-btn").classList.remove("d-none");
        });
    });

    // Handle "Save" button click
    document.querySelectorAll(".save-btn").forEach(btn => {
        btn.addEventListener("click", async (e) => {
            const button = e.currentTarget;              
            const row = button.closest("tr");
            const id = button.dataset.id;
            const route = button.dataset.route;

            const inputs = row.querySelectorAll(".edit-field");
            const data = {}
            inputs.forEach(input => {
                if (input.type !== "checkbox") data[input.name] = input.value;
                else {
                    data[input.name] = input.checked;
                }
            });
            
            // Send AJAX request with fetch
            const response = await fetch(route, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const responseData = await response.json();

            if (response.ok && responseData.success) {
                // Update the text fields
                const viewData = row.querySelectorAll(".view-field");
                //Biar gak usah nyari namanya di javascript, langsung ambil aja yang dapet dari controller
                if ('namaModalitas' in responseData){
                    data['modalitasId'] = responseData.namaModalitas;
                }

                viewData.forEach(view => {
                    if (view.dataset.type !== "checkbox") view.textContent = data[view.dataset.name];
                    else {
                        view.textContent = (data[view.dataset.name] ? "Ya" : "Tidak");
                    }
                });

                // Toggle back to view mode
                row.querySelectorAll(".view-field").forEach(el => el.classList.remove("d-none"));
                row.querySelectorAll(".edit-field").forEach(el => el.classList.add("d-none"));
                row.querySelector(".edit-btn").classList.remove("d-none");
                row.querySelector(".save-btn").classList.add("d-none");
            } else {
                alert("Update failed!");
            }
        });
    });
});