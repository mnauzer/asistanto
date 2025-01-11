<template>
  <div class="task-form">
    <h2 class="task-form-title">Pridať novú úlohu</h2>
    <form @submit.prevent="submitTask" class="task-form-container">
      <input
        v-model="title"
        placeholder="Názov úlohy"
        class="task-form-input"
      />
      <textarea
        v-model="description"
        placeholder="Popis úlohy"
        class="task-form-textarea"
      ></textarea>
      <button type="submit" class="task-form-button">Pridať</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "",
      description: "",
    };
  },
  methods: {
    async submitTask() {
      try {
        const response = await axios.post(
          `${import.meta.env.VITE_API_URL}/tasks`,
          {
            title: this.title,
            description: this.description,
          }
        );
        console.log(response.data);
        this.title = "";
        this.description = "";
      } catch (error) {
        console.error("Chyba pri pridávaní úlohy:", error);
      }
    },
  },
};
</script>

<style scoped>
.task-form {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.task-form-title {
  font-size: 1.5em;
  color: #333;
  margin-bottom: 15px;
  text-align: center;
}

.task-form-container {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.task-form-input,
.task-form-textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1em;
}

.task-form-input:focus,
.task-form-textarea:focus {
  outline: none;
  border-color: #007bff;
}

.task-form-textarea {
  resize: none;
  height: 80px;
}

.task-form-button {
  background-color: #007bff;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  font-size: 1em;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.task-form-button:hover {
  background-color: #0056b3;
}
</style>
