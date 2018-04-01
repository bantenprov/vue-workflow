import MenuItems from '../../../menu';

function getIndex(element) {
  return element.name == 'Admin';
}

let workflow_menu = 
{
  name: 'Workflow',        
  icon: 'fa fa-angle-double-right',
  child: [
    {
      name: 'Workflow',
      link: '/admin/workflow',
      icon: 'fa fa-angle-right'
    },
    {
      name: 'Transition',
      link: '/admin/workflow/transition',
      icon: 'fa fa-angle-right'
    },
    {
      name: 'State',
      link: '/admin/workflow/state',
      icon: 'fa fa-angle-right'
    }
  ]
};

MenuItems[MenuItems.findIndex(getIndex)].childItem.push(workflow_menu);

export default workflow_menu;