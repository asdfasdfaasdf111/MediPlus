document.addEventListener("DOMContentLoaded", () => {
    
    const rumahSakit = document.getElementById('rumahSakit');
    const jenisPemeriksaan = document.getElementById('jenisPemeriksaan');
    const jenisPemeriksaanSpesifik = document.getElementById('jenisPemeriksaanSpesifik');
    const tanggalPemeriksaan = document.getElementById('tanggalPemeriksaan');
    const tanggalPemeriksaanInput = document.getElementById('tanggalPemeriksaanInput');
    const rentangWaktuKedatangan = document.getElementById('rentangWaktuKedatangan');
    const submitBtn = document.getElementById('submitBtn');
    
    let rumahSakitValue = rumahSakit ? rumahSakit.value : window.rumahSakit.id;
    if (rumahSakit !== null){
        //kalo isiny kosong, brarti ga ad draft data, jadi tanggalnya di disable
        if (jenisPemeriksaanSpesifik.value == ""){
            tanggalPemeriksaan.calendar.set("disable", [
                function(date){
                    return true;
                }
            ]);
        }

        rumahSakit.addEventListener("change", (e) => {
            rumahSakitValue = rumahSakit.value;
            fetch(`/api/namaJenisPemeriksaan/${rumahSakitValue}`)
                .then(res => res.json())
                .then(data => {
                    jenisPemeriksaan.innerHTML = '<option value="-" disabled selected>-</option>';
    
                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item;
                        option.textContent = item;
                        jenisPemeriksaan.appendChild(option);
                    });
                });

            while (jenisPemeriksaanSpesifik.firstChild) {
                jenisPemeriksaanSpesifik.removeChild(jenisPemeriksaanSpesifik.firstChild);
            }
            
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
    }

    if (jenisPemeriksaan !== null){
        jenisPemeriksaan.addEventListener("change", (e) => {
    
            fetch(`/api/jenisPemeriksaanSpesifik/${rumahSakitValue}/${jenisPemeriksaan.value}`)
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
    }
    

    if (jenisPemeriksaanSpesifik !== null){
        //ambil jadwal di bulan itu, lalu update jadwal di bulan itu, mana aja yang available
        jenisPemeriksaanSpesifik.addEventListener("change", (e) => {
            tanggalPemeriksaan.calendar.clear(false);
            
            fetch(`/api/jadwalPenuh/${rumahSakitValue}/${jenisPemeriksaanSpesifik.value}`)
                .then(res => res.json())
                .then(data => {
                    tanggalPemeriksaan.calendar.set("disable", data);
                });

            while (rentangWaktuKedatangan.firstChild) {
                rentangWaktuKedatangan.removeChild(rentangWaktuKedatangan.firstChild);
            }

            submitBtn.disabled = true;
        });
    }
    

    tanggalPemeriksaan.calendar.config.onChange.push(function(selectedDates, dateStr) {
        while (rentangWaktuKedatangan.firstChild) {
            rentangWaktuKedatangan.removeChild(rentangWaktuKedatangan.firstChild);
        }
        tanggalPemeriksaanInput.value = dateStr;

        const idPart = window.dataPemeriksaan?.id ? `/${window.dataPemeriksaan.id}` : "";
        const jenisValue = jenisPemeriksaanSpesifik ? jenisPemeriksaanSpesifik.value : window.jenisPemeriksaan.id;
        const url = `/api/jamTersedia/${rumahSakitValue}/${jenisValue}/${dateStr}${idPart}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                data.forEach((slot, index) => {
                    const col = document.createElement("div");
                    col.className = "col";

                    const input = document.createElement("input");
                    input.type = "radio";
                    input.className = "btn-check";
                    input.name = "rentangWaktuKedatangan";
                    input.id = `slot-${index}`;
                    input.value = slot;
                    input.autocomplete = "off";
                    input.required = true;

                    const label = document.createElement("label");
                    label.className = "btn btn-outline-primary rounded-pill w-100 py-2 fw-semibold";
                    label.setAttribute("for", `slot-${index}`);

                    const [hour, minute] = slot.split(":").map(Number);
                    const endHour = (hour + 1) % 24;
                    label.textContent = `${slot} - ${String(endHour).padStart(2, "0")}:${String(minute).padStart(2, "0")}`;

                    col.appendChild(input);
                    col.appendChild(label);
                    rentangWaktuKedatangan.appendChild(col);
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