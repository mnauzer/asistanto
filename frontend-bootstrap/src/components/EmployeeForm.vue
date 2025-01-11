<template>
  <div class="employee-form">
    <h2>Správa zamestnancov</h2>
    <form @submit.prevent="handleSubmit">
      <div class="form-group">
        <label for="employee_number">Číslo zamestnanca</label>
        <input
          type="text"
          id="employee_number"
          v-model="employee.employee_number"
          required
        />
      </div>
      <div class="form-group">
        <label for="first_name">Meno</label>
        <input
          type="text"
          id="first_name"
          v-model="employee.first_name"
          required
        />
      </div>
      <div class="form-group">
        <label for="last_name">Priezvisko</label>
        <input
          type="text"
          id="last_name"
          v-model="employee.last_name"
          required
        />
      </div>
      <div class="form-group">
        <label for="nickname">Prezývka</label>
        <input
          type="text"
          id="nickname"
          v-model="employee.nickname"
        />
      </div>
      <div class="form-group">
        <label for="position">Pozícia</label>
        <input
          type="text"
          id="position"
          v-model="employee.position"
          required
        />
      </div>
      <div class="form-group">
        <label for="is_active">Aktívny</label>
        <input
          type="checkbox"
          id="is_active"
          v-model="employee.is_active"
        />
      </div>
      <button type="submit">Uložiť</button>
      <button type="button" @click="handleDelete">Vymazať</button>
    </form>
    <div v-if="error" class="error-message">{{ error }}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      employee: {
        employee_number: '',
        first_name: '',
        last_name: '',
        nickname: '',
        position: '',
        is_active: false,
      },
      error: null,
    };
  },
  methods: {
    async handleSubmit() {
      try {
        // Predpokladáme, že $axios je dostupný cez this.$axios
        const response = await this.$axios.post('/employees', this.employee);
        console.log('Zamestnanec pridaný:', response.data);
        // Môžeš pridať logiku pre úspešné pridanie zamestnanca
      } catch (error) {
        console.error('Chyba pri pridávaní zamestnanca:', error);
        this.error = 'Nepodarilo sa pridať zamestnanca. Skontrolujte údaje a skúste znova.';
      }
    },
    async handleDelete() {
      try {
        // Predpokladáme, že $axios je dostupný cez this.$axios
        const response = await this.$axios.delete(`/employees/${this.employee.employee_number}`);
        console.log('Zamestnanec vymazaný:', response.data);
        // Môžeš pridať logiku pre úspešné vymazanie zamestnanca
      } catch (error) {
        console.error('Chyba pri vymazávaní zamestnanca:', error);
        this.error = 'Nepodarilo sa vymazať zamestnanca. Skúste znova.';
      }
    },
  },
};
</script>

<style scoped>
.employee-form {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="number"] {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}

input[type="checkbox"] {
  margin-right: 5px;
}

button {
  padding: 10px 15px;
  margin-right: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

.error-message {
  color: red;
  font-weight: bold;
  margin-top: 10px;
}
</style>
