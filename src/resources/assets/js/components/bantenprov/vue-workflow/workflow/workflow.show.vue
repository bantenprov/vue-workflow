<template>
    <div>
		<div class="card mb-3">
			<div class="card-header d-flex flex-row align-items-center justify-content-between">
				<span>
					<i class="fa fa-table" aria-hidden="true"></i> Workflow
				</span>
				<button class="btn btn-primary btn-sm ml-2" role="button" @click="back">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</button>
			</div>

			<div class="card-body">
				<dl class="row">
					<dt class="col-2">Name</dt>
					<dd class="col-10">{{ model.name }}</dd>
					
					<dt class="col-2">Label</dt>
					<dd class="col-10">{{ model.label }}</dd>      

          <dt class="col-2">Workflow type</dt>
					<dd class="col-10">{{ model.workflow_type.label }}</dd> 

          <dt class="col-2">Content type</dt>
					<dd class="col-10">{{ model.content_type.label }}</dd> 
				</dl>
			</div>
		
	</div>
  	<div class="card">
		<div class="card-header d-flex flex-row align-items-center justify-content-between">
			<span>
				<i class="fa fa-table" aria-hidden="true"></i> Register Workflow
			</span>
		</div>    

		<div class="card-body">
			<vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">
				<div class="form-row mt-4">
					<div class="col-md">
						<validate tag="div">
						<label for="workflow_type">Workflow Type</label>
						<v-select name="workflow_type" v-model="model.workflow_type" :options="workflow_type" class="mb-4"></v-select>

						<field-messages name="workflow_type" show="$invalid && $submitted" class="text-danger">
							<small class="form-text text-success">Looks good!</small>
							<small class="form-text text-danger" slot="required">Label is a required field</small>
						</field-messages>
						</validate>
					</div>
				</div>
				<div class="form-row mt-4">
					<div class="col-md">
						<validate tag="div">
						<label for="content_type">Content Type</label>
						<v-select name="content_type" v-model="model.content_type" :options="content_type" class="mb-4"></v-select>

						<field-messages name="content_type" show="$invalid && $submitted" class="text-danger">
							<small class="form-text text-success">Looks good!</small>
							<small class="form-text text-danger" slot="required">Label is a required field</small>
						</field-messages>
						</validate>
					</div>
				</div>
				
				<div class="form-row mt-4">
					<div class="col-md">            
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</vue-form>
		</div>
    
  	</div>
  </div>
  
</template>

<script>
export default {
  mounted() {
    axios.get('vue-workflow/workflow/' + this.$route.params.id + '/show')
      .then(response => {
        if (response.data.status == true) {
          this.model.label = response.data.label;          
          this.model.name = response.data.name;          
          this.model.workflow_type = response.data.workflow_type;
          this.model.content_type = response.data.content_type;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/workflow';
	  });
	  axios.get('vue-workflow/workflow/create')
      .then(response => {
          
          response.data.forEach(element => {
            this.content_type.push(element);
          });
          //alert('Failed');          
          //console.log(this.content_type);
        
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/workflow';
      });
  },
  data() {
    return {
      state: {},
      model: {
        label: "",
        name: "",
        content_type:"",
        workflow_type: ""
	  },
	  content_type: [],
	  workflow_type: [
		  { id:1, label:'Content type'},
		  { id:2, label:'Content ID'}
	  ]
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
        axios.post('vue-workflow/workflow/' + this.$route.params.id + '/store-workflow', {
            content_type: this.model.content_type.label,
            workflow_type: this.model.workflow_type.label
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
            app.toast_message('error', 'error', 'error #500');
          });
      }
    },
    back() {
      window.location = '#/admin/workflow';
    }
  }
}
</script>
