<template>
  <div class="d-flex justify-content-center align-items-center flex-column">
    <h1 class="mt-5 text-center mb-3">Admin login</h1>
    <Form ref="loginForm" :model="loginForm" :rules="loginRules" class="mt-5">
        <FormItem prop="email">
            <Input type="email" v-model="loginForm.email" placeholder="email" style="width: 300px">
                <template #prepend>
                  <Icon type="ios-person-outline"></Icon>
                </template>
            </Input>
        </FormItem>
        <FormItem prop="password">
            <Input type="password" v-model="loginForm.password" placeholder="Password" style="width: 300px">
                <template #prepend>
                  <Icon type="ios-lock-outline"></Icon>
                </template>
            </Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="handleSubmit('loginForm')">Login</Button>
        </FormItem>
    </Form>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        loginForm: {
          email: '',
          password: ''
        },
        loginRules: {
          email: [
            { required: true, message: 'Please fill in the email', trigger: 'blur' },
            { type: 'email', message: 'This field must be an email', trigger: 'blur' }
          ],
          password: [
            { required: true, message: 'Please fill in the password.', trigger: 'blur' },
            { type: 'string', min: 6, message: 'The password length cannot be less than 6 bits', trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      handleSubmit(name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            this.login();
          }
          //  else {
          //   this.$Message.error('Fail!');
          // }
        });
      },
      async login () {
        const loginResult = await this.callApi('admin/login', 'POST', this.loginForm);

        if (loginResult.data.status) {
          this.successMsg('Logged in successfuly.');
          window.location = '/admin/dashboard';
        } else {
          this.errorMsg('Login failed.');
        }
      }
    }
  }
</script>
