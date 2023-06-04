export class User {
    id;
    firstName;
    lastName;
    email;
    selectedContact;

    constructor(userData) {
        this.id = userData.s_ID;
        this.firstName = userData.s_FirstName;
        this.lastName = userData.s_LastName;
        this.email = userData.s_Email;
    }

    selectContact(contactID) {
        this.selectedContact = contactID;
    }
}