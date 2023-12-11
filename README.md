# Student Project Management System

# Faculty Component:
The Faculty component is intended for teachers or faculty members and offers the following functionalities:

### Account Creation and Login: 
Faculty members can create an account by providing their details and then log in using their credentials.

### Homepage: 
Upon logging in, faculty members are directed to their homepage, which provides the following features:

 ### Add Students: 
Faculty members can add students to their project groups. The details collected for each student include:
 - Student name
 - Register number
 - Project type (selectable from a dropdown menu, with options for "Inhouse" and "PAT")

### Student Constraints: 
The system enforces a constraint that each faculty member can only add up to 5 students to their group. In the future, we plan to enhance this by associating students with faculty members through faculty IDs stored in the database.

Faculties are allowed to take up a maximum of 2 PAT of the 5 total projects

### Editing Student Data: 
Faculty members are not allowed to directly edit the details of the students once they are added. If any changes are needed, the faculty member can send a request to the admin.

### Request Submission: 
When faculty members need to modify student data, they can submit a request to the admin, specifying the required changes.

### Student Details Display: 
After entering the student data, the system displays the details of the students in an organized manner.

# Admin Component:
The Admin component is responsible for overseeing and managing the entire system. Key features include:

### Admin Login: 
Admins can log in using their credentials to access the admin panel.

### Data Alteration: 
Admins have the authority to alter all the data within the system. This includes managing faculty accounts, student records, and pending requests.

### Faculty Requests: 
Admins receive and process requests from faculty members for data changes. Admins can either approve or deny these requests.

### Permissions Management: 
Admins can grant or revoke access permissions to the faculty component as needed.

### Database Access: 
Admins have full access to all the data stored in the system's database, allowing them to maintain data integrity and system functionality.
