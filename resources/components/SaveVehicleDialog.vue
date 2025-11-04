<template>
    <div>
     <div class="pa-4 text-center">
    <v-dialog v-model="visible" max-width="600">
      <v-card prepend-icon="mdi-account" title="User Profile">
        <v-card-text>
          <v-row style="padding:20px 10px;color:red;"><small>{{ errorMessage }}</small></v-row>
          <v-row dense>
            <v-col cols="12" md="4" sm="6">
              <v-text-field 
              label="Registration number*" 
              name="registrationNumber"
              v-model="vehicle.registrationNumber"
              required
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4" sm="6">
              <v-text-field
                label="Brand*"
                name="brand"
                v-model="vehicle.brand"
                required
              ></v-text-field>
            </v-col>

            <v-col cols="12" md="4" sm="6">
              <v-text-field
                label="Model*"
                name="model"
                v-model="vehicle.model"
                required
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" sm="6">
              <v-select
                :items="['bus', 'passenger', 'truck']"
                label="Vehicle type*"
                name="type"
                v-model="vehicle.type"
                required
              ></v-select>
            </v-col>
          </v-row>
        
          <small class="text-caption text-medium-emphasis"
            >*indicates required field</small
          >
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="cancel()">Close</v-btn>
          <v-btn @click="save()">Save</v-btn>

        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
    </div>
</template>

<script setup>
    import { ref, reactive, watch } from 'vue'
    import { SaveVehicle } from '../services/Vehicle';
    import VehicleModel from '../classes/VehicleModel';

    const props = defineProps(['visible', 'vehicleToEdit']);
    const emit = defineEmits(['closed', 'saved'])

    const errorMessage = ref('');
    var vehicle = reactive(new VehicleModel());

    watch(() => props.vehicleToEdit, (newValue) => {
      if (newValue instanceof VehicleModel) {
        vehicle.id = newValue.id;
        vehicle.brand = newValue.brand;
        vehicle.model = newValue.model;
        vehicle.registrationNumber = newValue.registrationNumber;
        vehicle.type = newValue.type;
      }
    });

    const cancel = () => {
      clear();
      emit('closed');
    };

    const clear = () => {
      props.visible = false;
      vehicle.clear();
      errorMessage.value = '';
    };

    const save = async () => {
      errorMessage.value = '';

      if (vehicle.isFilled() === false) {
        errorMessage.value = 'Fill all required fields';
        return;
      }

      const result = await SaveVehicle(vehicle);

      if (result.success === true) {
          clear();
          emit('closed');
          emit('saved');
          return;
        }

      errorMessage.value = result.errorMessage;
    };
</script>
