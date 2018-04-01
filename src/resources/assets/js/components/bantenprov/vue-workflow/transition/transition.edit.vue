<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit Transition

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">
        <div class="form-row"><div class="col-md">
            <validate tag="div">
							<input class="form-control" v-model="model.name" name="old_name" type="hidden">

              <input class="form-control" v-model="model.name" name="name" type="text" placeholder="Name">

              <field-messages name="name" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
              </field-messages>
            </validate>
          </div>
        </div>
        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">              
              <input class="form-control" v-model="model.label" required autofocus name="label" type="text" placeholder="Label">

              <field-messages name="label" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="description">Description</label>
              <textarea class="form-control" v-model="model.description" required autofocus name="description" id="description" rows="3" placeholder="Description"></textarea>

              <field-messages name="description" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
            <div class="col-md">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" @click="reset">Reset</button>
            </div>
        </div>
      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('vue-workflow/transition/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {
          this.model.label = response.data.label;
          this.model.old_name = response.data.name;
          this.model.name = response.data.name;
          this.model.description = response.data.message;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/group-egovernment';
      });
  },
  data() {
    return {
      state: {},
      model: {
        label: "",
        name: "",
        description: ""
      }
    }
  },
  methods: {
		toast_message(typem,title,message,event) {
      switch (typem) {
        case 'success':
          miniToastr.success(message, title);
          break;
        case 'error':
          miniToastr.error(message, title);          
          break;
        case 'info':
          miniToastr.info(message, title);     
          break;
      }      
    },
    onSubmit: function() {
      let app = this;
      if (this.state.$invalid) {
        return;
      } else {
        axios.put('vue-workflow/transition/' + this.$route.params.id + '/update', {
            label: this.model.label,
            name: this.model.name,
            description: this.model.description,
            old_name: this.model.old_name
          })
          .then(response => {
            if (response.data.status == true) {              
                app.toast_message('success','update success',response.data.message);
                app.back();              
            } else {
              app.toast_message('error','update failed',response.data.message);
            }
          })
          .catch(function(response) {
            alert('Break ' + response.data.message);
          });
      }
    },
    reset() {
      axios.get('/vue-workflow/transition/' + this.$route.params.id + '/edit')
        .then(response => {            
          if (response.data.status == true) {
            this.model.label = response.data.label;
            this.model.name = response.data.name;
            this.model.description = response.data.description;
            
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/workflow/transition';
    }
  }
}
</script>
