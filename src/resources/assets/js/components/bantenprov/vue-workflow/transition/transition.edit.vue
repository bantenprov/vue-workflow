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
        <div class="form-row">
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
						<label for="workflow">Workflow</label>
						<v-select @input="onChange" name="workflow" v-model="model.workflow" :options="workflow" class="mb-4"></v-select>

						<field-messages name="workflow" show="$invalid && $submitted" class="text-danger">
							<small class="form-text text-success">Looks good!</small>
							<small class="form-text text-danger" slot="required">Workflow is a required field</small>
						</field-messages>
						</validate>
					</div>
				</div>   

        <div class="form-row mt-4">
					<div class="col-md">
						<validate tag="div">
						<label for="from">From</label>
						<v-select name="from" v-model="model.from" :options="from" class="mb-4"></v-select>

						<field-messages name="from" show="$invalid && $submitted" class="text-danger">
							<small class="form-text text-success">Looks good!</small>
							<small class="form-text text-danger" slot="required">From is a required field</small>
						</field-messages>
						</validate>
					</div>
				</div>    

        <div class="form-row mt-4">
					<div class="col-md">
						<validate tag="div">
						<label for="to">To</label>
						<v-select name="to" v-model="model.to" :options="to" class="mb-4"></v-select>

						<field-messages name="to" show="$invalid && $submitted" class="text-danger">
							<small class="form-text text-success">Looks good!</small>
							<small class="form-text text-danger" slot="required">to is a required field</small>
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
    axios.get('vue-workflow/transition/create')
    .then(response => {      
      response.data.forEach(element => {
        this.workflow.push(element);
      });
    })
    .catch(function(response) {
      alert('Break');
    }),

    axios.get('vue-workflow/transition/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {
          this.model.label = response.data.label;
          this.model.old_name = response.data.name;
          this.model.workflow = response.data.get_workflow;
          this.model.to = response.data.state_to;
          this.model.from = response.data.state_from;
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
        description: "",
        workflow: "",
        from: "",
        to: ""
      },
      workflow: [],
      from: [],
      to: [],
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
    onChange() {
      this.from = [];
      this.to = []; 
      axios.get('vue-workflow/transition/create/'+this.model.workflow.id+'/get-state')
      .then(response => {      
        response.data.forEach(element => {
          //console.log(this.model.workflow.id);
          this.from.push(element);
          this.to.push(element);
        });
      })
      .catch(function(response) {
        alert('Break');
      });
      
    },
    onSubmit: function() {
      let app = this;
      if (this.state.$invalid) {
        return;
      } else {
        axios.put('vue-workflow/transition/' + this.$route.params.id + '/update', {
            name: this.model.from.label +'-to-'+this.model.to.label,
            old_name: this.model.from.label +'-to-'+this.model.to.label,
            label: this.model.label,
            workflow_id: this.model.workflow.id,
            from: this.model.from.id,
            to: this.model.to.id,
            message: this.model.description
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
