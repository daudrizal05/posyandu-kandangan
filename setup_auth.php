<?php

$dir = __DIR__;

$files = [
    // UserModel
    'app/Models/UserModel.php' => <<<'PHP'
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'username', 'password', 'role', 'posyandu_id', 'is_active'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
PHP,

    // AuthController
    'app/Controllers/Auth.php' => <<<'PHP'
<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('auth/login');
    }

    public function process()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $user = $model->where('username', $username)->first();
        
        if ($user) {
            if (!$user['is_active']) {
                $session->setFlashdata('error', 'Akun Anda tidak aktif.');
                return redirect()->to('/login');
            }
            
            if (password_verify($password, $user['password'])) {
                $ses_data = [
                    'id'          => $user['id'],
                    'name'        => $user['name'],
                    'username'    => $user['username'],
                    'email'       => $user['email'],
                    'role'        => $user['role'],
                    'posyandu_id' => $user['posyandu_id'],
                    'isLoggedIn'  => true
                ];
                $session->set($ses_data);
                return redirect()->to('/admin/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
PHP,

    // AuthFilter
    'app/Filters/AuthFilter.php' => <<<'PHP'
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
PHP,

    // RoleFilter
    'app/Filters/RoleFilter.php' => <<<'PHP'
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');
        
        if ($arguments && !in_array($role, $arguments)) {
            return redirect()->to('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
PHP,

    // Admin Dashboard Controller
    'app/Controllers/Admin/Dashboard.php' => <<<'PHP'
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard E-Stunting'
        ];
        return view('admin/dashboard', $data);
    }
}
PHP,
];

foreach ($files as $path => $content) {
    $fullPath = $dir . '/' . $path;
    $dirPath = dirname($fullPath);
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0777, true);
    }
    file_put_contents($fullPath, $content);
    echo "Created: $path\n";
}

echo "Auth setup completed.\n";
