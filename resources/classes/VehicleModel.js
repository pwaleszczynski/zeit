class VehicleModel {
    constructor(id = null, registrationNumber = '', brand = '', model = '', type = '') {
        this.id = id;
        this.registrationNumber = registrationNumber;
        this.brand = brand;
        this.model = model;
        this.type = type;
      }

      isFilled() {
        return this.registrationNumber != '' 
        && this.brand != '' 
        && this.model != ''
        && this.type != '';
      }

      clear() {
        this.id = null;
        this.registrationNumber = '';
        this.brand = '';
        this.model = '';
        this.type = '';
      }
}

export default VehicleModel;
