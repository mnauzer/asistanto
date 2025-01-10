<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4">
      {{ isEditing ? "Edit Employee" : "Create New Employee" }}
    </h2>
    <form @submit.prevent="handleSubmit">
      <!-- Employee Number -->
      <div class="mb-4">
        <label for="employee_number" class="block text-sm font-medium text-gray-700">Employee Number</label>
        <input
          id="employee_number"
          v-model="employee.employee_number"
          type="text"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          required
        />
      </div>

      <!-- First Name -->
      <div class="mb-4">
        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
        <input
          id="first_name"
          v-model="employee.first_name"
          type="text"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          required
        />
      </div>

      <!-- Last Name -->
      <div class="mb-4">
        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
        <input
          id="last_name"
          v-model="employee.last_name"
          type="text"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          required
        />
      </div>

      <!-- Nickname -->
      <div class="mb-4">
        <label for="nickname" class="block text-sm font-medium text-gray-700">Nickname</label>
        <input
          id="nickname"
          v-model="employee.nickname"
          type="text"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
          required
        />
      </div>

      <!-- Position -->
      <div class="mb-4">
        <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
        <select
          id="position"
          v-model="employee.position"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
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
            class="form-checkbox text-indigo-600"
          />
          <span class="ml-2 text-sm text-gray-700">Active</span>
        </label>
      </div>

      <!-- Submit Buttons -->
      <div class="flex space-x-4">
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded"
        >
          {{ isEditing ? "Save Changes" : "Add Employee" }}
        </button>
        <button
          v-if="isEditing"
          type="button"
          @click="cancelEdit"
          class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded"
        >
          Cancel
        </button>
      </div>
    </form>

    <!-- Employee List -->
    <div class="mt-8">
      <h2 class="text-xl font-bold mb-4">Employee List</h2>
      <ul class="space-y-2">
        <li
          v-for="emp in employees"
          :key="emp.id"
          class="flex justify-between items-center bg-gray-100 p-4 rounded shadow"
        >
          <span>{{ emp.first_name }} {{ emp.last_name }} - {{ emp.position }}</span>
          <div>
            <button
              @click="editEmployee(emp)"
              class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1 px-3 rounded"
            >
              Edit
            </button>
            <button
              @click="deleteEmployee(emp.id)"
              class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded ml-2"
            >
              Delete
            </button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import this.$axios from "../axiosConfig";

export default {
  data() {
    return {
      employee: {
        employee_number: "",
        first_name: "",
        last_name: "",
        nickname: "",
        position: "employee",
        is_active: true,
      },
      employees: [],
      isEditing: false,
      editingId: null,
    };
  },
  methods: {
   async fetchEmployees() {
    try {
      const response = await this.$axios.get("/employees");
      console.log(response.data);
    } catch (error) {
      console.error("Error fetching employees:", error.message);
    }
  },
    async handleSubmit() {
      if (this.isEditing) {
        await this.updateEmployee();
      } else {
        await this.addEmployee();
      }
      this.resetForm();
      await this.fetchEmployees();
    },
    async addEmployee() {
      try {
        await this.$axios.post("/employees", this.employee);
      } catch (error) {
        console.error("Error adding employee:", error);
      }
    },
    async updateEmployee() {
      try {
        await this.$axios.put(`/employees/${this.editingId}`, this.employee);
      } catch (error) {
        console.error("Error updating employee:", error);
      }
    },
    async deleteEmployee(id) {
      try {
        await this.$axios.delete(`/employees/${id}`);
        await this.fetchEmployees();
      } catch (error) {
        console.error("Error deleting employee:", error);
      }
    },
    editEmployee(emp) {
      this.isEditing = true;
      this.editingId = emp.id;
      this.employee = { ...emp };
    },
    cancelEdit() {
      this.resetForm();
    },
    resetForm() {
      this.isEditing = false;
      this.editingId = null;
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
  async mounted() {
    await this.fetchEmployees();
  },
};
</script>

<style scoped>
/* Custom styles can go here */
</style>
