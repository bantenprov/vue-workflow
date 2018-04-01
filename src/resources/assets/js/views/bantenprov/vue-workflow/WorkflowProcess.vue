<template>
    <div>
        <div class="form-row mt-4">
        <div class="col-md">  
            <b>Current state :</b> <span v-html="model.current_state">{{ model.current_state }}</span>
        </div>
        </div> 

        <span v-if="model.check">
            <div class="form-row mt-4">
                <div class="col-md">
                    <b>By :</b> {{ model.current_history.user }}
                </div>
            </div>
        </span>

      <div class="form-row mt-4">
      <div class="col-md">   
        <button v-for="n in model.datas" type="button" :key="n.id" class="btn btn-primary mr-1" @click="onSubmit(n.id)"> {{ n.label }} </button>
      </div>
      </div>
      <div class="form-row mt-4">
        <div class="col-md">
        <validate tag="div">
            <label for="reason">Reason :</label>
            <textarea class="form-control" v-model="model.reason" required autofocus name="reason" id="reason" rows="3" placeholder="Reason"></textarea>

            <field-messages name="reason" show="$invalid && $submitted" class="text-danger">
            <small class="form-text text-success">Looks good!</small>
            <small class="form-text text-danger" slot="required">Reason is a required field</small>
            </field-messages>
        </validate>
        </div>
    </div>

    <div class="card-body">        
        <b>History :</b>
        <div style="margin:20px 0;">
            <div v-if="loading" class="d-flex justify-content-start align-items-center">
            <i class="fa fa-refresh fa-spin fa-fw"></i>
            <span>Loading...</span>
            </div>
        </div>

        <div class="table-responsive">
            <vuetable ref="vuetable"
            :api-url="api_url"
            :fields="fields"
            :sort-order="sortOrder"
            :css="css.table"
            pagination-path=""
            :per-page="5"
            :append-params="moreParams"
            @vuetable:pagination-data="onPaginationData"
            @vuetable:loading="onLoading"
            @vuetable:loaded="onLoaded">
            <template slot="actions" slot-scope="props">
                <div class="btn-group pull-right" role="group" style="display:flex;">
                
                </div>
            </template>
            </vuetable>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <vuetable-pagination-info ref="paginationInfo"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="pagination"
            :css="css.pagination"
            @vuetable-pagination:change-page="onChangePage">
            </vuetable-pagination>
            </div>
        </div>

    </div>
</template>

<style>
.vuetable-th-sequence{
  width: 1px;
}
.vuetable-th-slot-actions {
  width: 1px;
  white-space: normal;
}
</style>

<script>
// ganti nama component dg WorkflowTransition.vue
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';

export default {
    props: ['contentType'],
    components: {
        VuetablePaginationInfo
    },
    data(){
        
        return {
            model:{
                datas:[],
                entity:'',
                current_state:'',
                current_history:[{
                    content_type:'',
                    content_id:'',
                    workflow_id:'',
                    workflow_transition_id:'',
                    from_state:'',
                    to_state:'',
                    user:''
                }],
                reason:'',
                contenttype:this.contentType,
                check:false
            },
            api_url:"/vue-workflow/workflow-process/get-history/"+this.contentType+"/"+this.$route.params.id,
            loading: true,
            fields: [
                {
                name: '__sequence',
                title: '#',
                titleClass: 'center aligned',
                dataClass: 'right aligned'
                },
                {
                name: 'from_state.label',
                title: 'From',
                titleClass: 'center aligned'
                },
                {
                name: 'to_state.label',
                title: 'To',
                titleClass: 'center aligned'
                },
                {
                name: 'user.name',
                title: 'By',
                titleClass: 'center aligned'
                },
                {
                name: 'created_at',
                title: 'Date / Time',
                titleClass: 'center aligned'
                },
                {
                name: 'message',                
                title: 'Reason',
                titleClass: 'center aligned'
                }
            ],
            sortOrder: [{
                field: 'id',
                direction: 'asc'
            }],
            moreParams: {},
            css: {
                table: {
                tableClass: 'table table-hover',
                ascendingIcon: 'fa fa-chevron-up',
                descendingIcon: 'fa fa-chevron-down'
                },
                pagination: {
                wrapperClass: 'vuetable-pagination btn-group',
                activeClass: 'active',
                disabledClass: 'disabled',
                pageClass: 'btn btn-light',
                linkClass: 'btn btn-light',
                icons: {
                    first: 'fa fa-angle-double-left',
                    prev: 'fa fa-angle-left',
                    next: 'fa fa-angle-right',
                    last: 'fa fa-angle-double-right'
                }
                }
            }
            
        }
    },
    mounted(){
        var content_id = window.location.href.split('/');
        //console.log(content_id.slice(-1)[0]);
        this.model.entity = content_id.slice(-1)[0];
        //console.log(template)
        axios.get("/vue-workflow/workflow-process/"+this.contentType+"/"+content_id.slice(-1)[0])
        .then((response) => {
            //console.log(response);            

            if(response.data.status == true){
                this.model.check = true;
                var current_history_res = response.data.current_history; 

                this.model.current_history.content_type = current_history_res.content_type;
                this.model.current_history.content_id = current_history_res.content_id;
                this.model.current_history.workflow_id = current_history_res.workflow_id;
                this.model.current_history.workflow_transition_id = current_history_res.workflow_transition_id;
                this.model.current_history.from_state = current_history_res.from_state;
                this.model.current_history.to_state = current_history_res.to_state;
                this.model.current_history.user = response.data.user;

                response.data.state.forEach(element => {
                    this.model.datas.push(element)
                    //console.log(this.model.datas)                             
                });
                this.model.current_state = response.data.current_state.label
            }else{                
                this.model.current_state = '<b>whitout workflow</b>'
            }
            
            //console.log(this.model.current_state )
            
        })
        
    },
    methods:{
        back() {
            window.location = '#/admin/pendaftaran';
        },
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
        some_method(arg){
            //alert('clicked '+ arg)
            window.location='#/admin/'+arg+'/'+this.model.entity
        },

        onSubmit(arg){
            let app = this;
            
            /**
            * 
            * storeHistory($content_type, $content_id, $workflow_id, $workflow_transition_id, $from_state, $to_state, $user_id = '1')
            */
            axios.post('/vue-workflow/workflow-process/change-state/'+this.model.entity, {
                content_type:'Pendaftaran',
                workflow_id:this.model.current_history.workflow_id,
                workflow_transition_id:this.model.current_history.workflow_transition_id,
                from_state:this.model.current_history.from_state,
                to_state:arg,
                message: this.model.reason
            })
            .then((response)=>{
                if(response.data.status == true){
                    app.toast_message('success','success',response.data.message);
                }else{
                    app.toast_message('error','error',response.data.message);
                }
                
                //app.back(); 
                //app.$forceUpdate();
            })        
        },
        onPaginationData(paginationData) {
        this.$refs.pagination.setPaginationData(paginationData);
        this.$refs.paginationInfo.setPaginationData(paginationData);
        },
        onChangePage(page) {
        this.$refs.vuetable.changePage(page);
        },
        onLoading: function() {
        this.loading = true;
        },
        onLoaded: function() {
        this.loading = false;
        }
    },
    
}
</script>

