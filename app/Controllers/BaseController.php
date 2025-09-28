<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\CompanyModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $companyModel;
    protected $globalCompanies = [];

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');

        // Load Company Model
        $this->companyModel = new CompanyModel();
        
        // Load companies for global access
        $this->loadGlobalCompanies();
    }

    protected function loadGlobalCompanies()
    {
        $cache = \Config\Services::cache();
        $this->globalCompanies = $cache->get('global_companies');
        
        if (!$this->globalCompanies) {
            $this->globalCompanies = $this->companyModel->select('id, company_name')->orderBy('company_name', 'ASC')->findAll();
            $cache->save('global_companies', $this->globalCompanies, 3600);
        }
    }

    protected function shareWithView($data = [])
    {
        // Add global companies to all view data
        $data['globalCompanies'] = $this->globalCompanies;
        return $data;
    }
}
