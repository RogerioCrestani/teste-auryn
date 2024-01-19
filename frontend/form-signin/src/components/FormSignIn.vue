<template>
  <nav>
    <h1 class="h5 fw-bold text-center mb-4">Crie sua conta na memorar</h1>
    <form
      id="createAccount"
      class="row g-3 justify-content-center"
      @submit.prevent="signInFunction"
    >
      <div class="form-floating">
        <input
          type="name"
          class="form-control"
          id="floatingName"
          placeholder="Nome Completo"
          required
          min="3"
          v-model="userForm.name"
        />
        <label for="floatingName">Nome completo</label>
      </div>

      <div class="form-floating col-md-6 col-xs-12">
        <input
          type="tel"
          class="form-control"
          id="floatingFone"
          placeholder="Telefone"
          required
          pattern="\([1-9]{2}\) (?:[2-8]|9[0-9])[0-9]{3}\-[0-9]{4}"
          title="Seu telefone parece incorreto. Digite novamente por favor."
          v-model="userForm.phone"
        />
        <label for="floatingFone">Telefone</label>
      </div>
      <div class="form-floating col-md-6 col-xs-12">
        <input
          type="date"
          class="form-control"
          id="floatingBirth"
          placeholder="Data de nascimento"
          required
          v-model="userForm.birth"
        />
        <label for="floatingBirth">Data de nascimento</label>
      </div>

      <div class="form-floating">
        <input
          type="email"
          class="form-control"
          id="floatingMail"
          placeholder="Email"
          required
          pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
          title="Seu email parece incorreto. Digite novamente por favor."
          v-model="userForm.mail"
        />
        <label for="floatingMail">Email</label>
      </div>

      <div class="form-floating col-md-6 col-xs-12">
        <input
          type="password"
          class="form-control"
          id="floatingPassword"
          placeholder="Crie uma senha"
          required
          v-model="userForm.password"
        />
        <label for="floatingPassword">Crie uma senha</label>
      </div>
      <div class="form-floating col-md-6 col-xs-12">
        <input
          type="password"
          class="form-control"
          id="floatingPasswordRepeat"
          placeholder="Repita a senha"
          required
          v-model="userForm.passwordRepeat"
        />
        <label for="floatingPasswordRepeat">Repita a senha</label>
      </div>

      <div class="form-floating">
        <input
          type="text"
          class="form-control"
          id="floatingCpf"
          placeholder="Seu CPF"
          required
          pattern="/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/"
          title="Seu CPF parece incorreto. Digite novamente por favor."
          v-model="userForm.cpf"
        />
        <label for="floatingCpf">Seu CPF</label>
      </div>

      <div class="alert alert-danger" id="errorMessage" v-if="showErrorMessage">
        {{ errorMessage }}
      </div>

      <input
        type="submit"
        value="Criar conta"
        id="submission"
        class="btn btn-primary p-3 px-5 col-auto fw-normal bg-gradient"
      />
    </form>
  </nav>
</template>
  
<script>
import axios from "axios";

export default {
  name: "FormSignIn",
  methods: {
    signInFunction: function () {
      if (this.userForm.password != this.userForm.passwordRepeat) {
        this.errorMessage = "As senhas são diferentes, por favor verifique.";
        this.showErrorMessage = true;
      } else {
        this.showErrorMessage = false;
        const data = new URLSearchParams();

        for (var [key, value] of Object.entries(this.userForm)) {
          data.append(key, value);
        }

        console.log(data);

        axios.post("http://localhost:9090/users", data).then(() => {
          console.log("inserido com sucesso!");
        });
      }

      console.log("cadastrou");
    },
  },
  data: () => {
    return {
      userForm: {},
      errorMessage: "",
      showErrorMessage: false,
    };
  },
};
</script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
</style>