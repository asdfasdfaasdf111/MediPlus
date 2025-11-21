document.addEventListener("DOMContentLoaded", () => {

    const jenisPemeriksaan = document.getElementById('jenisPemeriksaan');
    const jenisPemeriksaanSpesifik = document.getElementById('jenisPemeriksaanSpesifik');
    const tanggalPemeriksaan = document.getElementById('tanggalPemeriksaan');
    const tanggalPemeriksaanInput = document.getElementById('tanggalPemeriksaanInput');
    const rentangWaktuKedatangan = document.getElementById('rentangWaktuKedatangan');
    const submitBtn = document.getElementById('submitBtn');

    jenisPemeriksaan.addEventListener("change", (e) => {
    
        fetch(`/petugas/api/jenisPemeriksaanSpesifik/${window.rumahSakit.id}/${jenisPemeriksaan.value}`)
            .then(res => res.json())
            .then(data => {
                jenisPemeriksaanSpesifik.innerHTML = '<option value="-" disabled selected>-</option>';

                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.namaPemeriksaanSpesifik;
                    jenisPemeriksaanSpesifik.appendChild(option);
                });
            });
        
        tanggalPemeriksaan.calendar.set("disable", [
            function(date){
                return true;
            }
        ]);

        while (rentangWaktuKedatangan.firstChild) {
            rentangWaktuKedatangan.removeChild(rentangWaktuKedatangan.firstChild);
        }

        submitBtn.disabled = true;
    });


    jenisPemeriksaanSpesifik.addEventListener("change", (e) => {
        tanggalPemeriksaan.calendar.clear(false);
        
        fetch(`/petugas/api/jadwalPenuh/${window.rumahSakit.id}/${jenisPemeriksaanSpesifik.value}`)
            .then(res => res.json())
            .then(data => {
                tanggalPemeriksaan.calendar.set("disable", data);
            });

        while (rentangWaktuKedatangan.firstChild) {
            rentangWaktuKedatangan.removeChild(rentangWaktuKedatangan.firstChild);
        }

        submitBtn.disabled = true;
    });

    tanggalPemeriksaan.calendar.config.onChange.push(function(selectedDates, dateStr) {
        while (rentangWaktuKedatangan.firstChild) {
            rentangWaktuKedatangan.removeChild(rentangWaktuKedatangan.firstChild);
        }
        tanggalPemeriksaanInput.value = dateStr;
        fetch(`/petugas/api/jamTersedia/${window.rumahSakit.id}/${jenisPemeriksaanSpesifik.value}/${dateStr}/${window.dataPemeriksaan.id}`)
            .then(res => res.json())
            .then(data => {
                data.forEach((slot, index) => {
                    const input = document.createElement("input");
                    input.type = "radio";
                    input.className = "btn-check";
                    input.name = "rentangWaktuKedatangan";
                    input.id = `slot-${index}`;
                    input.value = slot;
                    input.autocomplete = "off";
                    input.required = true;

                    const label = document.createElement("label");
                    label.className = "btn btn-outline-primary rounded-pill p-2";
                    label.setAttribute("for", `slot-${index}`);

                    const [hour, minute] = slot.split(":").map(Number);
                    const endHour = (hour + 1) % 24;
                    label.textContent = `${slot} - ${String(endHour).padStart(2, "0")}:${String(minute).padStart(2, "0")}`;

                    rentangWaktuKedatangan.appendChild(input);
                    rentangWaktuKedatangan.appendChild(label);
                });
            });

        submitBtn.disabled = true;
    });

    
    rentangWaktuKedatangan.addEventListener('change', (event) => {
        if (event.target.name === 'rentangWaktuKedatangan') {
            submitBtn.disabled = false;
        }
    });
});