@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-6">Shoe Mart API Documentation</h1>

            <!-- Introduction -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-3">Introduction</h2>
                <p class="text-gray-700 mb-2">
                    Welcome to the Shoe Mart API. This RESTful API provides programmatic access to manage products, 
                    orders, and authentication. All responses are returned in JSON format.
                </p>
                <p class="text-gray-700">
                    <strong>Base URL:</strong> <code class="bg-gray-100 px-2 py-1 rounded">{{ url('/api') }}</code>
                </p>
            </div>

            <!-- Authentication -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-3">Authentication</h2>
                <p class="text-gray-700 mb-4">
                    The API uses Laravel Sanctum for authentication. To authenticate, you need to obtain an API token 
                    by logging in via the admin login endpoint.
                </p>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">Admin Login</h3>
                    <p class="text-sm mb-2"><span class="bg-green-500 text-white px-2 py-1 rounded">POST</span> /api/admin/login</p>
                    
                    <div class="bg-white p-3 rounded border">
                        <p class="text-sm font-medium mb-2">Request Body:</p>
                        <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "email": "admin@example.com",
  "password": "password"
}</code></pre>
                    </div>

                    <div class="bg-white p-3 rounded border mt-3">
                        <p class="text-sm font-medium mb-2">Response (200 OK):</p>
                        <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "success": true,
  "message": "Login successful",
  "data": {
    "admin": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com"
    },
    "token": "1|abc123..."
  }
}</code></pre>
                    </div>
                </div>

                <p class="text-gray-700 mb-2">
                    Include the token in subsequent requests using the Bearer authentication scheme:
                </p>
                <div class="bg-gray-900 text-gray-100 p-3 rounded">
                    <code class="text-sm">Authorization: Bearer YOUR_TOKEN_HERE</code>
                </div>
            </div>

            <!-- Products Endpoints -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-3">Products</h2>

                <!-- Get All Products -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">Get All Products</h3>
                    <p class="text-sm mb-2"><span class="bg-blue-500 text-white px-2 py-1 rounded">GET</span> /api/products</p>
                    <p class="text-sm text-gray-600 mb-2">Public - No authentication required</p>
                    
                    <div class="bg-white p-3 rounded border mt-3">
                        <p class="text-sm font-medium mb-2">Response (200 OK):</p>
                        <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Nike Air Max",
      "description": "Premium running shoes",
      "price": 129.99,
      "category": "running",
      "stock": 50,
      "image": "products/shoe1.jpg",
      "created_at": "2026-01-15T10:30:00.000000Z",
      "updated_at": "2026-01-15T10:30:00.000000Z"
    }
  ]
}</code></pre>
                    </div>
                </div>

                <!-- Get Single Product -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">Get Single Product</h3>
                    <p class="text-sm mb-2"><span class="bg-blue-500 text-white px-2 py-1 rounded">GET</span> /api/products/{id}</p>
                    <p class="text-sm text-gray-600 mb-2">Public - No authentication required</p>
                    
                    <div class="bg-white p-3 rounded border mt-3">
                        <p class="text-sm font-medium mb-2">Response (200 OK):</p>
                        <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "success": true,
  "data": {
    "id": 1,
    "name": "Nike Air Max",
    "description": "Premium running shoes",
    "price": 129.99,
    "category": "running",
    "stock": 50,
    "image": "products/shoe1.jpg"
  }
}</code></pre>
                    </div>
                </div>

                <!-- Create Product -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">Create Product (Admin Only)</h3>
                    <p class="text-sm mb-2"><span class="bg-green-500 text-white px-2 py-1 rounded">POST</span> /api/products</p>
                    <p class="text-sm text-red-600 mb-2">🔒 Requires authentication</p>
                    
                    <div class="bg-white p-3 rounded border">
                        <p class="text-sm font-medium mb-2">Request Body (multipart/form-data):</p>
                        <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "name": "Nike Air Max",
  "description": "Premium running shoes",
  "price": 129.99,
  "category": "running",
  "stock": 50,
  "image": &lt;file&gt;
}</code></pre>
                    </div>
                </div>

                <!-- Update Product -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">Update Product (Admin Only)</h3>
                    <p class="text-sm mb-2"><span class="bg-yellow-500 text-white px-2 py-1 rounded">PUT</span> /api/products/{id}</p>
                    <p class="text-sm text-red-600 mb-2">🔒 Requires authentication</p>
                </div>

                <!-- Delete Product -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">Delete Product (Admin Only)</h3>
                    <p class="text-sm mb-2"><span class="bg-red-500 text-white px-2 py-1 rounded">DELETE</span> /api/products/{id}</p>
                    <p class="text-sm text-red-600 mb-2">🔒 Requires authentication</p>
                </div>
            </div>

            <!-- Error Responses -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-3">Error Responses</h2>
                
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">401 Unauthorized</h3>
                    <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "success": false,
  "message": "Invalid credentials"
}</code></pre>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">404 Not Found</h3>
                    <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "success": false,
  "message": "Product not found"
}</code></pre>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                    <h3 class="font-semibold mb-2">422 Validation Error</h3>
                    <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>{
  "success": false,
  "errors": {
    "name": ["The name field is required."],
    "price": ["The price must be a number."]
  }
}</code></pre>
                </div>
            </div>

            <!-- Rate Limiting -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-3">Rate Limiting</h2>
                <p class="text-gray-700">
                    API requests are rate-limited to 60 requests per minute per IP address. 
                    Exceeding this limit will result in a 429 (Too Many Requests) response.
                </p>
            </div>

            <!-- Security -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-3">Security Features</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li><strong>HTTPS Only:</strong> All API requests should be made over HTTPS in production</li>
                    <li><strong>Token Authentication:</strong> Laravel Sanctum tokens with expiration support</li>
                    <li><strong>Multi-device Support:</strong> Separate tokens for different devices/sessions</li>
                    <li><strong>Token Revocation:</strong> Ability to revoke tokens at any time</li>
                    <li><strong>Input Validation:</strong> All inputs are validated and sanitized</li>
                    <li><strong>SQL Injection Prevention:</strong> Eloquent ORM protects against SQL injection</li>
                    <li><strong>XSS Prevention:</strong> Blade templating escapes output by default</li>
                    <li><strong>CSRF Protection:</strong> Enabled for all state-changing requests</li>
                </ul>
            </div>

            <!-- Code Examples -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-3">Code Examples</h2>
                
                <h3 class="font-semibold mb-2">JavaScript (Fetch API)</h3>
                <pre class="text-xs bg-gray-900 text-gray-100 p-4 rounded overflow-x-auto mb-4"><code>// Get all products
fetch('{{ url('/api/products') }}')
  .then(response => response.json())
  .then(data => console.log(data));

// Create product (with authentication)
fetch('{{ url('/api/products') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer YOUR_TOKEN',
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    name: 'Nike Air Max',
    description: 'Premium running shoes',
    price: 129.99,
    category: 'running',
    stock: 50
  })
})
  .then(response => response.json())
  .then(data => console.log(data));</code></pre>

                <h3 class="font-semibold mb-2">cURL</h3>
                <pre class="text-xs bg-gray-900 text-gray-100 p-4 rounded overflow-x-auto"><code># Get all products
curl {{ url('/api/products') }}

# Create product (with authentication)
curl -X POST {{ url('/api/products') }} \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Nike Air Max",
    "description": "Premium running shoes",
    "price": 129.99,
    "category": "running",
    "stock": 50
  }'</code></pre>
            </div>
        </div>
    </div>
</div>
@endsection
