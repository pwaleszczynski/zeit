class ApiResult {
    constructor (success = false, errorMessage = '', data = {}) {
        this.success = success;
        this.errorMessage = errorMessage;
        this.data = data;
    }
}

export default ApiResult;
