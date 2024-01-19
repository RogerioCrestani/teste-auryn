<template>
  <div>
    <table id="cadastros" class="table table-striped mt-5">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nome</th>
          <th scope="col">Telefone</th>
          <th scope="col">Nascimento</th>
          <th scope="col">Email</th>
          <th scope="col">CPF</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <th scope="row">{{ user.id }}</th>
          <td>{{ user.name }}</td>
          <td>{{ user.phone }}</td>
          <td>{{ user.birth }}</td>
          <td>{{ user.mail }}</td>
          <td>{{ user.cpf }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
  
  <script>
import axios from "axios";

export default {
  name: "TableUsers",
  data: function () {
    return {
      users: {},
    };
  },
  methods: {
    getUsers: function () {
      axios.get("http://localhost:9090/users").then((response) => {
        this.users = response.data;
      });
    },
  },
  mounted: function () {
    this.getUsers();
  },
};
</script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
</style>