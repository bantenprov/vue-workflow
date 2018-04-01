<?php namespace Bantenprov\VueWorkflow\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\VueWorkflow\Facades\VueWorkflow;
use Bantenprov\VueWorkflow\Models\VueWorkflowModel;

/**
 * The VueWorkflowController class.
 *
 * @package Bantenprov\VueWorkflow
 * @author  bantenprov <developer.bantenprov@gmai.com>
 */
class VueWorkflowController extends Controller
{
    public function demo()
    {
        return VueWorkflow::welcome();
    }
}
