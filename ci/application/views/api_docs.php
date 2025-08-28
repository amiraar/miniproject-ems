<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-border-radius: 0.75rem;
            --transition-speed: 0.3s;
        }
        
        .endpoint-card { 
            margin-bottom: 1rem; 
            border-radius: var(--bs-border-radius);
            transition: all var(--transition-speed) ease;
        }
        
        .endpoint-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .method-get { background: #28a745; }
        .method-post { background: #007bff; }
        .method-put { background: #ffc107; color: #000; }
        .method-delete { background: #dc3545; }
        .method-badge { 
            color: white; 
            padding: 6px 12px; 
            border-radius: 6px; 
            font-size: 12px; 
            font-weight: bold; 
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .response-example { 
            background: var(--bs-light); 
            padding: 15px; 
            border-radius: var(--bs-border-radius); 
            margin-top: 10px; 
            border: 1px solid var(--bs-border-color);
        }
        
        pre { 
            margin: 0; 
            font-size: 14px; 
        }
        
        .hero-section { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 3rem 0; 
            margin-bottom: 2rem; 
            border-radius: 0 0 var(--bs-border-radius) var(--bs-border-radius);
        }
        
        .api-status { 
            padding: 8px 16px; 
            border-radius: 25px; 
            font-size: 14px; 
            font-weight: bold; 
        }
        
        .status-working { 
            background: #28a745; 
            color: white; 
        }
        
        .feature-icon { 
            font-size: 2.5rem; 
            margin-bottom: 1rem; 
        }
        
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            border-radius: 50px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all var(--transition-speed) ease;
        }
        
        .theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }
        
        .theme-toggle i {
            font-size: 1.5rem;
            transition: transform var(--transition-speed) ease;
        }
        
        .theme-toggle:hover i {
            transform: rotate(180deg);
        }
        
        @media (max-width: 768px) {
            .theme-toggle {
                width: 50px;
                height: 50px;
                top: 15px;
                right: 15px;
            }
            
            .theme-toggle i {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="btn btn-primary theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4">🚀 CodeIgniter EMS API</h1>
            <p class="lead">RESTful API Documentation & Testing Interface</p>
            <span class="api-status status-working">✅ ACTIVE & WORKING</span>
        </div>
    </div>

    <div class="container">
        <!-- Base URL Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5>📡 Base URL:</h5>
                    <code id="baseUrl">http://localhost/CodeIgniter-EMS/ci/index.php/api</code>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="copyToClipboard('baseUrl')">📋 Copy</button>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="feature-icon">📁</div>
                        <h5>Department API</h5>
                        <p class="text-muted">3 Endpoints</p>
                        <span class="api-status status-working">Working</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="feature-icon">👥</div>
                        <h5>Employee API</h5>
                        <p class="text-muted">Coming Soon</p>
                        <span class="api-status" style="background: #ffc107; color: #000;">Planned</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="feature-icon">🔐</div>
                        <h5>Auth API</h5>
                        <p class="text-muted">Coming Soon</p>
                        <span class="api-status" style="background: #ffc107; color: #000;">Planned</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="feature-icon">📊</div>
                        <h5>Performance</h5>
                        <p class="text-muted">Monitoring</p>
                        <span class="api-status status-working">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department API -->
        <div class="card endpoint-card">
            <div class="card-header bg-primary text-white">
                <h3>📁 Department API</h3>
                <p class="mb-0">Manage departments with full CRUD operations</p>
            </div>
            <div class="card-body">
                
                <!-- GET Departments -->
                <div class="mb-4 p-3 border rounded">
                    <h5>
                        <span class="method-badge method-get">GET</span>
                        Get All Departments
                    </h5>
                    <p><strong>Endpoint:</strong> <code>/departments</code></p>
                    <p><strong>Description:</strong> Retrieve paginated list of all departments</p>
                    
                    <h6>Parameters (Optional):</h6>
                    <ul>
                        <li><code>limit</code> - Number of results (default: 10)</li>
                        <li><code>offset</code> - Start position (default: 0)</li>
                        <li><code>search</code> - Search term</li>
                    </ul>
                    
                    <h6>Example URL:</h6>
                    <div class="response-example">
                        <code>GET /api/departments?limit=5&offset=0&search=IT</code>
                    </div>
                    
                    <h6>Response Example:</h6>
                    <div class="response-example">
                        <pre><code class="language-json">{
  "status": "success",
  "message": "Departments retrieved successfully",
  "timestamp": "2025-08-28 15:30:00",
  "data": [
    {
      "id": "1",
      "name": "IT Department",
      "created_at": "2025-08-26 14:30:59"
    },
    {
      "id": "2", 
      "name": "Human Resources",
      "created_at": "2025-08-26 14:30:59"
    }
  ],
  "pagination": {
    "total": 7,
    "limit": 10,
    "offset": 0,
    "has_more": false
  }
}</code></pre>
                    </div>
                    
                    <button class="btn btn-primary btn-sm mt-2" onclick="testApi('/departments', 'GET')">
                        🧪 Test This API
                    </button>
                </div>

                <!-- GET Department by ID -->
                <div class="mb-4 p-3 border rounded">
                    <h5>
                        <span class="method-badge method-get">GET</span>
                        Get Department by ID
                    </h5>
                    <p><strong>Endpoint:</strong> <code>/departments/{id}</code></p>
                    <p><strong>Description:</strong> Retrieve specific department by ID</p>
                    
                    <h6>Example URL:</h6>
                    <div class="response-example">
                        <code>GET /api/departments/1</code>
                    </div>
                    
                    <h6>Response Example:</h6>
                    <div class="response-example">
                        <pre><code class="language-json">{
  "status": "success",
  "message": "Success",
  "timestamp": "2025-08-28 15:30:00",
  "data": {
    "id": "1",
    "name": "IT Department",
    "created_at": "2025-08-26 14:30:59"
  }
}</code></pre>
                    </div>
                    
                    <div class="mt-2">
                        <input type="number" id="deptId" class="form-control d-inline-block" style="width: 100px;" value="1" min="1">
                        <button class="btn btn-primary btn-sm ms-2" onclick="testApiWithId()">
                            🧪 Test Get by ID
                        </button>
                    </div>
                </div>

                <!-- POST Create Department -->
                <div class="mb-4 p-3 border rounded">
                    <h5>
                        <span class="method-badge method-post">POST</span>
                        Create New Department
                    </h5>
                    <p><strong>Endpoint:</strong> <code>/departments/create</code></p>
                    <p><strong>Description:</strong> Create a new department</p>
                    
                    <h6>Request Headers:</h6>
                    <div class="response-example">
                        <code>Content-Type: application/json</code>
                    </div>
                    
                    <h6>Request Body:</h6>
                    <div class="response-example">
                        <pre><code class="language-json">{
  "name": "Department Name" // Required, min 2 characters
}</code></pre>
                    </div>
                    
                    <h6>Response Example (Success):</h6>
                    <div class="response-example">
                        <pre><code class="language-json">{
  "status": "success",
  "message": "Department created successfully",
  "timestamp": "2025-08-28 15:30:00",
  "data": {
    "id": "9",
    "name": "Marketing Department",
    "created_at": "2025-08-28 15:30:00"
  }
}</code></pre>
                    </div>
                    
                    <div class="mt-3">
                        <div class="mb-2">
                            <label class="form-label">Department Name:</label>
                            <input type="text" id="newDeptName" class="form-control" placeholder="Enter department name" value="Test Department">
                        </div>
                        <button class="btn btn-success btn-sm" onclick="testCreateDept()">
                            ➕ Test Create Department
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Response Display -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <h4>🔬 Live API Test Results</h4>
            </div>
            <div class="card-body">
                <div id="apiResponse" class="response-example">
                    <p class="text-muted">👆 Click any "Test This API" button above to see live responses here</p>
                </div>
            </div>
        </div>

        <!-- Tools & Examples -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>🛠️ Testing Tools</h4>
                    </div>
                    <div class="card-body">
                        <h6>Recommended Tools:</h6>
                        <ul>
                            <li><strong>Postman:</strong> <a href="https://www.postman.com/" target="_blank">Download</a></li>
                            <li><strong>Thunder Client:</strong> VS Code Extension</li>
                            <li><strong>Browser:</strong> For GET requests</li>
                            <li><strong>PowerShell:</strong> Built-in Windows tool</li>
                        </ul>
                        
                        <a href="<?= base_url('performance_dashboard.php') ?>" class="btn btn-info btn-sm">
                            📊 Performance Dashboard
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>💻 PowerShell Examples</h4>
                    </div>
                    <div class="card-body">
                        <div class="response-example">
                            <pre><code># GET All Departments
Invoke-RestMethod -Uri "http://localhost/CodeIgniter-EMS/ci/index.php/api/departments"

# GET Department by ID
Invoke-RestMethod -Uri "http://localhost/CodeIgniter-EMS/ci/index.php/api/departments/1"

# CREATE Department
$body = @{name="New Department"} | ConvertTo-Json
Invoke-RestMethod -Uri "http://localhost/CodeIgniter-EMS/ci/index.php/api/departments/create" -Method POST -Body $body -ContentType "application/json"</code></pre>
                        </div>
                        
                        <button class="btn btn-outline-primary btn-sm" onclick="copyToClipboard('powershellCode')">
                            📋 Copy PowerShell Code
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-5 mb-4">
            <div class="col-12 text-center">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5>🎯 API Status: Fully Operational</h5>
                        <p class="text-muted">Last Updated: August 28, 2025 | Performance Monitoring: Active</p>
                        <small class="text-muted">
                            💡 Need help? Check the PowerShell examples or use the test buttons above
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const baseUrl = 'http://localhost/CodeIgniter-EMS/ci/index.php/api';
        
        // Theme Manager Class
        class ThemeManager {
            constructor() {
                this.theme = localStorage.getItem('theme') || 'light';
                this.toggleBtn = document.getElementById('themeToggle');
                this.themeIcon = document.getElementById('themeIcon');
                
                this.init();
            }
            
            init() {
                this.applyTheme(this.theme);
                this.toggleBtn.addEventListener('click', () => this.toggleTheme());
            }
            
            toggleTheme() {
                this.theme = this.theme === 'light' ? 'dark' : 'light';
                this.applyTheme(this.theme);
                localStorage.setItem('theme', this.theme);
            }
            
            applyTheme(theme) {
                document.documentElement.setAttribute('data-bs-theme', theme);
                
                if (theme === 'dark') {
                    this.themeIcon.className = 'fas fa-sun';
                    this.toggleBtn.title = 'Switch to Light Mode';
                } else {
                    this.themeIcon.className = 'fas fa-moon';
                    this.toggleBtn.title = 'Switch to Dark Mode';
                }
            }
        }
        
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            const text = element.textContent || element.value;
            navigator.clipboard.writeText(text).then(() => {
                // Create toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification';
                toast.innerHTML = '<i class="fas fa-check me-2"></i>Copied to clipboard!';
                toast.style.cssText = `
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: var(--bs-success);
                    color: white;
                    padding: 12px 20px;
                    border-radius: 25px;
                    z-index: 9999;
                    font-size: 14px;
                    font-weight: 500;
                `;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 2000);
            });
        }
        
        async function testApi(endpoint, method) {
            const responseDiv = document.getElementById('apiResponse');
            responseDiv.innerHTML = `
                <div class="text-info d-flex align-items-center">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    <span>Testing API endpoint...</span>
                </div>
            `;
            
            try {
                const response = await fetch(baseUrl + endpoint, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                responseDiv.innerHTML = `
                    <div class="mb-3">
                        <h6 class="d-flex align-items-center">
                            ${response.ok ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>'}
                            Response (${response.status} ${response.statusText})
                        </h6>
                        <small class="text-muted">
                            <i class="fas fa-link me-1"></i>
                            ${baseUrl + endpoint}
                        </small>
                    </div>
                    <pre><code class="language-json">${JSON.stringify(data, null, 2)}</code></pre>
                `;
                
                Prism.highlightAll();
                
            } catch (error) {
                responseDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Error:</h6>
                        <p class="mb-0">${error.message}</p>
                    </div>
                `;
            }
        }
        
        async function testApiWithId() {
            const id = document.getElementById('deptId').value;
            if (!id) {
                alert('Please enter a department ID');
                return;
            }
            await testApi(`/departments/${id}`, 'GET');
        }
        
        async function testCreateDept() {
            const name = document.getElementById('newDeptName').value.trim();
            
            if (!name) {
                alert('Please enter a department name');
                return;
            }
            
            const responseDiv = document.getElementById('apiResponse');
            responseDiv.innerHTML = `
                <div class="text-info d-flex align-items-center">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    <span>Creating department...</span>
                </div>
            `;
            
            try {
                const response = await fetch(baseUrl + '/departments/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name
                    })
                });
                
                const data = await response.json();
                
                responseDiv.innerHTML = `
                    <div class="mb-3">
                        <h6 class="d-flex align-items-center">
                            ${response.ok ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-times-circle text-danger me-2"></i>'}
                            Create Response (${response.status} ${response.statusText})
                        </h6>
                        <small class="text-muted">
                            <i class="fas fa-link me-1"></i>
                            ${baseUrl}/departments/create
                        </small>
                    </div>
                    <pre><code class="language-json">${JSON.stringify(data, null, 2)}</code></pre>
                `;
                
                Prism.highlightAll();
                
                // Clear the input if successful
                if (response.ok) {
                    document.getElementById('newDeptName').value = '';
                    // Show success notification
                    const toast = document.createElement('div');
                    toast.innerHTML = '<i class="fas fa-check me-2"></i>Department created successfully!';
                    toast.style.cssText = `
                        position: fixed;
                        top: 20px;
                        left: 50%;
                        transform: translateX(-50%);
                        background: var(--bs-success);
                        color: white;
                        padding: 12px 20px;
                        border-radius: 25px;
                        z-index: 9999;
                        font-size: 14px;
                        font-weight: 500;
                    `;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 3000);
                }
                
            } catch (error) {
                responseDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Create Error:</h6>
                        <p class="mb-0">${error.message}</p>
                    </div>
                `;
            }
        }
        
        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize theme manager
            new ThemeManager();
            
            // Initialize syntax highlighting
            Prism.highlightAll();
            
            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';
            
            // Add entrance animations
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        });
    </script>
</body>
</html>