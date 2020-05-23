## Decryptoid

### A web application that allows users to encrypt and decrypt texts in input or text file. The user can select from a list of ciphers and specify if it needs encryption or decryption.

Live on https://decryptoid-2337.herokuapp.com/
### Notice

The live demo disabled connection to MySQL database, any database are disabled include authentication, registeration and history record.

### About

The application consists of four web pages:

- User authentication (login) page (disabled/view only)
- User registeration (sign up) page (disabled/view only)
- Main cipher page
- History page (disabled)

All information related to the user accounts (username, password and email) are stored in MYSQL database in the most secure way.Credential information stored in the Database are salted and hashed.

The application prevents regular attack such as: - SQL injection - Session hijacking - Packet Sniffing - Session Fixation.
