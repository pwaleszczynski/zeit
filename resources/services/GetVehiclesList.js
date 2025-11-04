import axios from "axios";
import Config from "../Config";


const fetchFromApi = async () => {
    return await axios.get(Config.vehicleApiUrl+'/list');
}

const GetVehiclesList = async () => {
    const result = await fetchFromApi();
    
    return result.data.results;
};

export default GetVehiclesList;