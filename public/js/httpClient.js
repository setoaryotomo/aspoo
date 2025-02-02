const initializeHttpClient = (csrf_token) => {
    httpClient = axios.create({
        timeout: 500000,
        headers: {
            'X-CSRF-TOKEN': csrf_token
        }
    })

    const successHandler = (response) => {
        return response
    }
    const errorHandler = (error) => {
        if (!error.response) {
            throw error
        }
        throw error.response.data
    }
    httpClient.interceptors.response.use((response) => successHandler(response), (error) => errorHandler(error))
};