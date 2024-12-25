let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

let mainImage = document.querySelector('.quick-view .box .row .image-container .main-image img');
let subImages = document.querySelectorAll('.quick-view .box .row .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});


const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

// format rupiah e lur
var rupiah = document.getElementById("rupiah");
rupiah.addEventListener("keyup", function(e) {
  // tambahkan 'Rp.' pada saat form di ketik
  // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
  rupiah.value = formatRupiah(this.value, "Rp. ");
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
   var number_string = angka.replace(/[^,\d]/g, "").toString(),
     split = number_string.split(","),
     sisa = split[0].length % 3,
     rupiah = split[0].substr(0, sisa),
     ribuan = split[0].substr(sisa).match(/\d{3}/gi);
 
   // tambahkan titik jika yang di input sudah menjadi angka ribuan
   if (ribuan) {
     separator = sisa ? "." : "";
     rupiah += separator + ribuan.join(".");
   }
 
   rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
   return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
 }
 


//   RUPIAH
 /* Tanpa Rupiah */
 var tanpa_rupiah = document.getElementById('tanpa-rupiah');
 tanpa_rupiah.addEventListener('keyup', function(e)
 {
     tanpa_rupiah.value = formatRupiah(this.value);
 });
 
 /* Dengan Rupiah */
 var dengan_rupiah = document.getElementById('dengan-rupiah');
 dengan_rupiah.addEventListener('keyup', function(e)
 {
     dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
 });
 
 /* Fungsi */
 function formatRupiah(angka, prefix)
 {
     var number_string = angka.replace(/[^,\d]/g, '').toString(),
         split    = number_string.split(','),
         sisa     = split[0].length % 3,
         rupiah     = split[0].substr(0, sisa),
         ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
         
     if (ribuan) {
         separator = sisa ? '.' : '';
         rupiah += separator + ribuan.join('.');
     }
     
     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
     return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
 }
