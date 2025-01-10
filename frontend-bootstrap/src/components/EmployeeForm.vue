<template>
  <div class="max-w-xl mx-auto p-4 border rounded shadow">
    <h2 class="text-2xl font-bold mb-4">
      {{ isEdit ? "Edit Employee" : "Create Employee" }}
    </h2>
    <form @submit.prevent="handleSubmit">
      <!-- Employee Number -->
      <div class="mb-4">
        <label for="employee_number" class="block font-medium">Employee Number</label>
        <input
          id="employee_number"
          v-model="employee.employee_number"
          type="text"
          class="w-full p-2 border rounded"
          required
        />
      </div>

      <!-- First Name -->
      <div class="mb-4">
        <label for="first_name" class="block font-medium">First Name</label>
        <input
          id="first_name"
          v-model="employee.first_name"
          type="text"
          class="w-full p-2 border rounded"
          required
        />
      </div>

      <!-- Last Name -->
      <div class="mb-4">
        <label for="last_name" class="block font-medium">Last Name</label>
        <input
          id="last_name"
          v-model="employee.last_name"
          type="text"
          class="w-full p-2 border rounded"
          required
        />
      </div>

      <!-- Nickname -->
      <div class="mb-4">
        <label for="nickname" class="block font-medium">Nickname</label>
        <input
          id="nickname"
          v-model="employee.nickname"
          type="text"
          class="w-full p-2 border rounded"
          required
        />
      </div>

      <!-- Position -->
      <div class="mb-4">
        <label for="position" class="block font-medium">Position</label>
        <select
          id="position"
          v-model="employee.position"
          class="w-full p-2 border rounded"
          required
        >
          <option value="manager">Manager</option>
          <option value="employee">Employee</option>
          <option value="intern">Intern</option>
          <option value="external">External</option>
        </select>
      </div>

      <!-- Active Status -->
      <div class="mb-4">
        <label class="inline-flex items-center">
          <input
            type="checkbox"
            v-model="employee.is_active"
            class="form-checkbox"
          />
          <span class="ml-2">Active</span>
        </label>
      </div>

      <!-- Submit Button -->
      <div class="mt-4">
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
        >
          {{ isEdit ? "Update Employee" : "Create Employee" }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    employeeId: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      isEdit: false,
      employee: {
        employee_number: "",
        first_name: "",
        last_name: "",
        nickname: "",
        position: "employee",
        is_active: true,
      },
    };
  },
  methods: {
    async fetchEmployee() {
      if (this.employeeId) {
        this.isEdit = true;
        try {
          const response = await axios.get(`/api/employees/${this.employeeId}`);
          this.employee = response.data;
        } catch (error) {
          console.error("Error fetching employee:", error);
        }
      }
    },
    async handleSubmit() {
      try {
        if (this.isEdit) {
          await axios.put(`/api/employees/${this.employeeId}`, this.employee);
          alert("Employee updated successfully!");
        } else {
          await axios.post("/api/employees", this.employee);
          alert("Employee created successfully!");
          this.resetForm();
        }
      } catch (error) {
        console.error("Error submitting form:", error);
        alert("An error occurred while saving the employee.");
      }
    },
    resetForm() {
      this.employee = {
        employee_number: "",
        first_name: "",
        last_name: "",
        nickname: "",
        position: "employee",
        is_active: true,
      };
    },
  },
  mounted() {
    this.fetchEmployee();
  },
};
</script>

<style scoped>
/* Optional: Add some custom styles */
</style>
