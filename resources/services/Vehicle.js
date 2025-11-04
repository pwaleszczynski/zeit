import axios from "axios";
import Config from "../Config";
import ApiResult from "../classes/ApiResult";

const SaveVehicle = async (vehicle) => {
    const result = await SaveVehicleByApi(vehicle);

    return result;
};

const SaveVehicleByApi = async (vehicle) => {
    var result = new ApiResult();
    const url = (vehicle.id === null) ? Config.vehicleApiUrl+'/save' : Config.vehicleApiUrl+'/save/'+vehicle.id;

    await axios
        .post(url, {
        registrationNumber: vehicle.registrationNumber,
        brand: vehicle.brand,
        model: vehicle.model,
        type: vehicle.type
        })
        .then((res) => {
        result.success = true;
        })
        .catch((error) => {
        result.success = false;
        result.errorMessage = error.response.data.error;
        });

    return result;
};

const DeleteVehicle = async (id) => {
    const result = await DeleteVehicleByApi(id);

    return result;
};

const DeleteVehicleByApi = async (id) => {
    var result = new ApiResult();
    
    await axios
    .post(Config.vehicleApiUrl+'/delete/'+id)
    .then ((res) => {
        result.success = true;
    })
    .catch((error) => {
        result.success = false;
        result.errorMessage = error.response.data.error;
    });

    return result;
};

export { SaveVehicle, DeleteVehicle }