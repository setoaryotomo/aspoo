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
})
const showToast = ({
    message,
    type = 'success' //primary, secondary, succes, danger, info, warning, light,dark
}) => {
    // configure color
    Toast.fire({
        icon: type,
        title: message
    })
}