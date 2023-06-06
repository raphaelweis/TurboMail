export class User {
    #id;
    #firstName;
    #lastName;
    #email;
    #selectedContact;

    constructor() {
        this.#id = undefined
        this.#firstName = undefined
        this.#lastName = undefined
        this.#email = undefined
        this.#selectedContact = undefined;
    }

    // setters
    setUserData(userData) {
        this.#id = userData.s_ID;
        this.#firstName = userData.s_FirstName;
        this.#lastName = userData.s_LastName;
        this.#email = userData.s_Email;
    }

    setSelectedContact(contact) {
        this.#selectedContact = contact;
    }

    // getters
    getId() {
        return this.#id;
    }

    getFirstName() {
        return this.#firstName;
    }

    getLastName() {
        return this.#lastName;
    }

    getEmail() {
        return this.#email;
    }

    getSelectedContact() {
        return this.#selectedContact;
    }
}