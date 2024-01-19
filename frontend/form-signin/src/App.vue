<template>
  <div id="app">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Memorar</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <div class="container col-md-5 col-lg-5 col-xl-4 my-5">
      <div class="w-50 mx-auto my-4">
        <a href="#">
          <img
            src="./assets/logo-memorar.png"
            alt="Logo memorar"
            class="mw-100"
          />
        </a>
      </div>

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

          <div
            class="alert alert-danger"
            id="errorMessage"
            v-if="showErrorMessage"
          >
            {{ errorMessage }}
          </div>
          <div
            class="alert alert-success"
            id="successMessage"
            v-if="showSuccessMessage"
          >
            {{ successMessage }}
          </div>

          <input
            type="submit"
            value="Criar conta"
            id="submission"
            class="btn btn-primary p-3 px-5 col-auto fw-normal bg-gradient"
          />
        </form>
      </nav>
    </div>

    <div class="container">
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
            <td>{{ user.birthDate }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.cpf }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  data: function () {
    return {
      users: {},
      userForm: {},
      errorMessage: "",
      showErrorMessage: false,
      successMessage: "",
      showSuccessMessage: false,
    };
  },
  methods: {
    getUsers: function () {
      axios
        .get("http://localhost:9090/users")
        .then((response) => {
          this.users = response.data;
        })
        .catch(() => {
          this.errorMessage =
            "Ocorreu ao exibir os usuários, por favor recarregue a página.";
          this.showErrorMessage = true;
        });
    },
    signInFunction: function () {
      if (this.userForm.password != this.userForm.passwordRepeat) {
        this.errorMessage = "As senhas são diferentes, por favor verifique.";
        this.showErrorMessage = true;
      } else {
        var repeatUser = false;
        for (var user of this.users) {
          console.log(user);
          if (
            user.name == this.userForm.name ||
            user.mail == this.userForm.mail ||
            user.cpf == this.userForm.cpf
          ) {
            repeatUser = true;
            break;
          }
        }

        if (repeatUser) {
          this.errorMessage =
            "Usuário, e-mail ou CPF já cadastrados, deseja recuperar a senha?";
          this.showErrorMessage = true;
        } else {
          this.showErrorMessage = false;
          const data = new URLSearchParams();

          for (var [key, value] of Object.entries(this.userForm)) {
            data.append(key, value);
          }

          axios
            .post("http://localhost:9090/users", data)
            .then(() => {
              this.getUsers();

              this.successMessage = `Usuário ${this.userForm.name} cadastrado com sucesso!`;
              this.showSuccessMessage = true;

              this.userForm = {
                name: "",
                phone: "",
                mail: "",
                birth: "",
                password: "",
                passwordRepeat: "",
                cpf: "",
              };

              this.showErrorMessage = false;
            })
            .catch((error) => {
              this.errorMessage =
                "Ocorreu um erro no cadastro do usuário, por favor tente novamente";
              console.log(error);
              this.showErrorMessage = true;
            });
        }
      }
    },
  },
  mounted: function () {
    this.getUsers();
  },
};
</script>

<style>
body {
  font-family: "Work Sans", sans-serif;
}

#createAccount label {
  left: auto;
}
</style>
