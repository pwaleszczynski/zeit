<template>
    <div>
      <SaveVehicleDialog :visible="showCreateVehicleDialog" @closed="showCreateVehicleDialog=false" @saved="fetchVehicles()" />
      <SaveVehicleDialog :visible="showUpdateVehicleDialog" :vehicleToEdit="vehicleToEdit" @closed="showUpdateVehicleDialog=false" @saved="fetchVehicles()" />
      <div style="text-align: right;padding:10px;"><v-btn @click="showCreateVehicleDialog=true">Create vehicle</v-btn></div>
        <v-data-table 
            :items="vehicles" 
            :headers="headers" 
            class="elevation-1"
        >
        <template v-slot:item="{ item, index }">
        <tr>
          <td>
            {{ index + 1 }}
          </td>
          <td>{{item.registrationNumber}}</td>
          <td>{{item.brand}}</td>
          <td>{{item.model}}</td>
          <td style="text-transform: capitalize;">{{item.type}}</td>
          <td>{{item.createdAt}}</td>
          <td>{{item.updatedAt}}</td>
          <td>
            <v-btn @click="openUpdateVehicleDialog(item)">Edit</v-btn>
            <v-btn @click="deleteVehicle(item.id)">Delete</v-btn>
          </td>
        </tr>
      </template>

        </v-data-table>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import SaveVehicleDialog from './SaveVehicleDialog.vue';
    import GetVehiclesList from '../services/GetVehiclesList';
    import { DeleteVehicle } from '../services/Vehicle';
    import VehicleModel from '../classes/VehicleModel';

    const headers = [
        {text: 'No.', align: 'left'},
        {text: 'Registration Number', align: 'left', value: 'registrationNumber'},
        {text: 'Brand', align: 'left', value: 'brand'},
        {text: 'Model', align: 'left', value: 'model'},
        {text: 'Vehicle', align: 'left', value: 'type'},
        {text: 'Creation Date', align: 'left', value: 'createdAt'},
        {text: 'Modification Date', align: 'left', value: 'updatedAt'},
        {text: 'Actions', align: 'left'},
    ];
    const vehicles = ref([]);
    const showCreateVehicleDialog = ref(false);
    const showUpdateVehicleDialog = ref(false);
    const vehicleToEdit = ref(null);
  
    const fetchVehicles = async () => {
        vehicles.value = await GetVehiclesList();
    }

    const deleteVehicle = async (id) => {
        result = await DeleteVehicle(id);

        if (result.success === true) {
          fetchVehicles();
        }
    }

    const openUpdateVehicleDialog = (item) => {
      showUpdateVehicleDialog.value = true;
      vehicleToEdit.value = new VehicleModel(
        item.id,
        item.registrationNumber,
        item.brand,
        item.model,
        item.type
      );
    }

    onMounted( async () => {
        await fetchVehicles();
    });
    
</script>
