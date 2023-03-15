<template>
  <div class="d-flex justify-content-center align-items-center flex-column">
    <h1 class="mt-5 text-center mb-3">Register</h1>
    <Form ref="registerForm" :model="registerForm" :rules="registerRules" class="mt-5">
        <FormItem prop="name">
            <Input type="text" v-model="registerForm.name" placeholder="Full Name" style="width: 300px">
                <template #prepend>
                  <Icon type="ios-person-outline"></Icon>
                </template>
            </Input>
        </FormItem>
        <FormItem prop="email">
            <Input type="email" v-model="registerForm.email" placeholder="email" style="width: 300px">
                <template #prepend>
                  <Icon type="ios-person-outline"></Icon>
                </template>
            </Input>
        </FormItem>
        <FormItem prop="password">
            <Input type="password" v-model="registerForm.password" placeholder="Password" style="width: 300px">
                <template #prepend>
                  <Icon type="ios-lock-outline"></Icon>
                </template>
            </Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="handleSubmit('registerForm')">Register</Button>
        </FormItem>
    </Form>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        registerForm: {
          name: '',
          email: '',
          password: ''
        },
        registerRules: {
          name: [
            { required: true, message: 'Please fill in the full name', trigger: 'blur' },
          ],
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
            console.log(this.registerForm);
            this.register();
          }
          //  else {
          //   this.$Message.error('Fail!');
          // }
        });
      },
      async register () {
        const registerResult = await this.callApi('register', 'POST', this.registerForm);

        if (registerResult.data.status) {
          this.successMsg('Registred successfuly.');
          this.$router.push('/');
        } else {
          this.errorMsg('Registration failed.');
        }
      }
    }
  }
</script>
