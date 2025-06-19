# MentalKu API - Postman Collection

This folder contains the Postman collection for testing the MentalKu API.

## Files

- `MentalKu_API.postman_collection.json` - The main collection with all API endpoints

## How to Import

1. Open Postman
2. Click on "Import" button
3. Choose the collection file (`MentalKu_API.postman_collection.json`)
4. Create an environment with a variable called `base_url` set to your server URL (e.g., `http://localhost:8000`)

## Testing Flow

1. **Authentication:**
   - Register a new user or login with existing credentials
   - The auth token will be automatically saved to the environment variables

2. **Testing DASS-21:**
   - Get the test questions
   - Submit a test (with or without authentication)
   - View test history and details (requires authentication)

3. **Admin Functions:**
   - Create professional accounts (requires admin token)
   - View list of professional accounts
   - View professional account details
   - Update professional account information
   - Delete professional accounts

## Important Authentication Notes

- **Bearer Token**: The collection has been updated to include explicit `Authorization: Bearer {{token}}` headers in addition to the Postman auth settings. This ensures proper authentication with Laravel Sanctum.

- **Login/Register**: After successful login or registration, the token is automatically saved to the environment variable and logged to the console.

- **Auth Status**: For the authenticated test submission, a test script has been added to verify if the request was properly authenticated (check console output).

- **Common Issue**: If your test submissions aren't being saved to the database, ensure you're properly authenticated. The response will include `"tersimpan": true` if the authentication was successful.

## API Routes Overview

### Public Endpoints
- `POST /api/login` - Authenticate user
- `POST /api/register` - Register new user
- `GET /api/pengujian/pertanyaan` - Get DASS-21 test questions
- `POST /api/pengujian/submit/anonymous` - Submit test without authentication

### Protected Endpoints (require authentication)
- `GET /api/user` - Get authenticated user info
- `POST /api/user/update-profile` - Update user profile information
- `POST /api/logout` - Logout and invalidate token
- `POST /api/pengujian/submit` - Submit test with authentication (saves to database)
- `GET /api/pengujian/riwayat` - Get test history
- `GET /api/pengujian/detailpengujian/{id}` - Get specific test details
- `DELETE /api/pengujian/hapusPengujian/{id}` - Delete a test record

### Admin Only Endpoints
- `POST /api/admin/create-professional` - Create a new professional account
- `GET /api/admin/professionals` - List all professional accounts
- `GET /api/admin/professionals/{id}` - Get professional account details
- `PUT /api/admin/professionals/{id}` - Update professional account details
- `DELETE /api/admin/professionals/{id}` - Delete a professional account 