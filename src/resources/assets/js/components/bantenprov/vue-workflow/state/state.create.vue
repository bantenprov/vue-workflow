<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add State

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
        <div class="form-row">
          <div class="col-md">
            <validate tag="div">
              <label for="Name">Name</label>
              <input class="form-control" v-model="model.name" required autofocus name="name" type="text" placeholder="Name">

              <field-messages name="name" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label is a required field</small>
              </field-messages>
            </validate>
          </div>                            
        </div>
        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="label">Label</label>
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
						<label for="workflow">Workflow</label>
						<v-select name="workflow" v-model="model.workflow" :options="workflow" class="mb-4"></v-select>

						<field-messages name="workflow" show="$invalid && $submitted" class="text-danger">
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
                <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>    
          </div>
        </div>
      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  mounted(){
    axios.get('vue-workflow/state/create')
      .then(response => {        
          this.workflow = response.data;      
      })
      .catch(function(response) {
        alert('Break');
      });

  },
  data() {
    return {
      state: {},
      model: {
        name: "",
        label: "",
        description: "",
        workflow: ""
      },
      workflow: []
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
        axios.post('vue-workflow/state/store', {
            name: this.model.name,
            label: this.model.label,
            description: this.model.description,
            workflow_id: this.model.workflow.id
          })
          .then(response => {  
                      
            if (response.data.status == true) {              
                app.toast_message('success','add success',response.data.message);
                app.back();              
            } else {
              app.toast_message('error','add failed',response.data.message);              
            }
          })
          .catch(function(response) {
            console.log(response)  
            //alert('Break ' + response.data.message);        
          });
      }
    },
    reset() {
      this.model = {
          label: "",
          name: "",
          description: ""
      };
    },
    back() {
      window.location = '#/admin/workflow/state';
    }
  }
}
</script>