const showLoading = () => {
    Swal.fire({
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    })
}

const hideLoading = async () => {
    await Swal.close()
}