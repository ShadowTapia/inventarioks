import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
import './../../vendor/power-components/livewire-powergrid/dist/tailwind.css';
import '../../vendor/masmerise/livewire-toaster/resources/js';
import Swal from 'sweetalert2';


/* var myFile = "";
$('#file').on('change', function () {
    myFile = $(this).val();
    var ext = myFile.split('.').pop();
    if (ext == "jpg" || ext == "jpe" || ext == "png") {
        alert(ext);
    } else {
        alert(ext);
    }
});
 */
//Cambiar imagen
// document.getElementById("file").addEventListener('change', cambiarImagen);

// function cambiarImagen(event) {
//     var file = event.target.files[0];

//     var reader = new FileReader();

//     reader.onload = (event) => {
//         document.getElementById("picture").setAttribute('src', event.target.result);
//     };

//     reader.readAsDataURL(file);
// }

//Preparamos el Toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
//Desplegamos el toast ante un evento de alerta
window.addEventListener('alert', (event) => {
    const eventData = event.detail;
    const type = eventData[0].type;
    const message = eventData[0].message;

    Toast.fire({
        icon: type,
        title: message
    })
});



