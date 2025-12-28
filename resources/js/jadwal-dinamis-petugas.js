document.addEventListener("DOMContentLoaded", () => {
    
    const kelompokJenisPemeriksaan = document.getElementById('kelompokJenisPemeriksaan');
    const jenisPemeriksaan = document.getElementById('jenisPemeriksaan');
    const tanggalPemeriksaan = document.getElementById('tanggalPemeriksaan');
    const tanggalPemeriksaanInput = document.getElementById('tanggalPemeriksaanInput');
    const rentangWaktuKedatangan = document.getElementById('rentangWaktuKedatangan');
    const submitBtn = document.getElementById('submitBtn');
    const slotInfo = document.getElementById('slotInfo');
    
    let rumahSakitValue = window.rumahSakit.id;

    //kalo isiny kosong, brarti ga ad draft data, jadi tanggalnya di disable
    if (jenisPemeriksaan.value == ""){
        tanggalPemeriksaan.calendar.set("disable", [
            function(date){
                return true;
            }
        ]);
    }

    if (kelompokJenisPemeriksaan !== null){
        kelompokJenisPemeriksaan.addEventListener("change", (e) => {
    
            fetch(`/api/namaJenisPemeriksaan/${rumahSakitValue}/${kelompokJenisPemeriksaan.value}`)
                .then(res => res.json())
                .then(data => {
                    jenisPemeriksaan.innerHTML = '<option value="-" disabled selected>-</option>';
    
                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.namaJenisPemeriksaan;
                        jenisPemeriksaan.appendChild(option);
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
    

    if (jenisPemeriksaan !== null){
        //ambil jadwal di bulan itu, lalu update jadwal di bulan itu, mana aja yang available
        jenisPemeriksaan.addEventListener("change", (e) => {
            tanggalPemeriksaan.calendar.clear(false);
            
            fetch(`/api/jadwalPenuhPetugas/${rumahSakitValue}/${jenisPemeriksaan.value}`)
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
        const jenisValue = jenisPemeriksaan ? jenisPemeriksaan.value : window.jenisPemeriksaan.id;
        const url = `/api/jamTersediaPetugas/${rumahSakitValue}/${jenisValue}/${dateStr}`;
        
        fetch(url)
        .then(res => res.json())
        .then(data => {
                const jump = data.jump;
                const listJam = data.listJam;
                listJam.forEach((slot, index) => {
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
                    const endHour = (hour + jump) % 24;
                    label.textContent = `${slot} - ${String(endHour).padStart(2, "0")}:${String(minute).padStart(2, "0")}`;

                    col.appendChild(input);
                    col.appendChild(label);
                    rentangWaktuKedatangan.appendChild(col);
                });
                if (slotInfo != null){
                    slotInfo.textContent = `${jump} jam/slot`;
                }
            });


        submitBtn.disabled = true;
    });

    
    rentangWaktuKedatangan.addEventListener('change', (event) => {
        if (event.target.name === 'rentangWaktuKedatangan') {
            submitBtn.disabled = false;
        }
    });
});