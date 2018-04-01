const workflow_routes = [
	{
		path: '/admin/workflow',
		name: 'admin.workflow',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.index.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Workflow"
		}
	},
	{
		path: '/admin/workflow/create',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.create.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Workflow | add"
		}
	},
	{
		path: '/admin/workflow/:id/show',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.show.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Workflow | show worfklow"
		}
	},
	{
		path: '/admin/workflow/:id/edit',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/workflow/workflow.edit.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Workflow | show worfklow"
		}
	},
	{
		path: '/admin/workflow/state',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/state/state.index.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "State"
		}
	},
	
	{
		path: '/admin/workflow/transition',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.index.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Transition"
		}
	},
	{
		path: '/admin/workflow/state/create',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/state/state.create.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "State | add new state"
		}
	},
	{
		path: '/admin/workflow/state/:id/edit',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/state/state.edit.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "State | edit state"
		}
	},
	{
		path: '/admin/workflow/transition',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.index.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Transition"
		}
	},
	{
		path: '/admin/workflow/transition/create',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.create.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Tranisiton | add transition"
		}
	},
	{
		path: '/admin/workflow/transition/:id/edit',
		components: {
			main: resolve => require(['~/components/bantenprov/vue-workflow/transition/transition.edit.vue'], resolve),
			navbar: resolve => require(['~/components/Navbar.vue'], resolve),
			sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
		},
		meta: {
			title: "Tranisiton | edit tranisiton"
		}
	}
];



export default workflow_routes;