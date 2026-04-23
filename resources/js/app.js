function updateSummary() {
    const checks = [...document.querySelectorAll('.slot-checkbox:checked')];
    const hours  = checks.map(c => parseInt(c.value)).sort((a,b) => a-b);
    
    // Ambil nilai payment_type yang dipilih
    const paymentType = document.querySelector('input[name="payment_type"]:checked').value;

    const box      = document.getElementById('summaryBox');
    const btn      = document.getElementById('submitBtn');
    const totalEl  = document.getElementById('summaryTotal');
    const fullText = document.getElementById('text-price-full');
    const dpText   = document.getElementById('text-price-dp');

    // Jika tidak ada slot dipilih, reset harga jadi 0
    if(!hours.length) {
        if(fullText) fullText.textContent = 'Rp 0';
        if(dpText) dpText.textContent = 'Rp 0';
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-calendar-check"></i> Pilih Slot Terlebih Dahulu';
        return;
    }

    // 1. Hitung Total Harga
    let total = 0;
    hours.forEach(h => {
        total += slotPrices[h];
    });

    // 2. Update Teks di Radio Button
    if(fullText) fullText.textContent = 'Rp ' + total.toLocaleString('id-ID');
    if(dpText) dpText.textContent = 'Rp ' + (total * 0.5).toLocaleString('id-ID');

    // 3. Hitung berapa yang harus dibayar sekarang
    let amountToPay = (paymentType === 'dp') ? (total * 0.5) : total;

    // 4. Update Tampilan Ringkasan & Tombol
    totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    btn.disabled = false;
    
    let label = (paymentType === 'dp') ? 'DP 50%' : 'LUNAS';
    btn.innerHTML = `<i class="fas fa-calendar-check"></i> Booking ${hours.length} Slot (${label}) — Rp ${amountToPay.toLocaleString('id-ID')}`;
}