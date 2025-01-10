<template>
  <div>
    <h1>Tasks</h1>
    <form @submit.prevent="submitTask">
      <input v-model="title" placeholder="Title" />
      <textarea v-model="description" placeholder="Description"></textarea>
      <button type="submit">Add Task</button>
    </form>

    <ul>
      <li v-for="task in tasks" :key="task.id">{{ task.title }} - {{ task.description }}</li>
    </ul>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      title: "",
      description: "",
      tasks: []
    };
  },
  async mounted() {
    const response = await axios.get(`${import.meta.env.VITE_API_URL}/tasks`);
    this.tasks = response.data;
  },
  methods: {
    async submitTask() {
      const response = await axios.post(`${import.meta.env.VITE_API_URL}/tasks`, {
        title: this.title,
        description: this.description
      });
      this.tasks.push(response.data);
      this.title = "";
      this.description = "";
    }
  }
};
</script>
