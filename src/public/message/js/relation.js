import {loggedInUser} from "./router.js";

const FETCH_CONTACTS_URL = '../../app/fetch_contacts.php'

//-------------------------//
// Public Functions        //
//-------------------------//

export function setupRelations() {
    const addFriendButton = $('#add-friend-button');

    updateContacts();

    addFriendButton.on('click', () => {
        showAddFriendDialog();
    });
}

export function errorDetector(error, errorDiv) {
    const SUCCESS = 0;
    const EMPTY_INPUTS = 1;
    const INVALID_EMAIL = 2;
    const USER_NOT_FOUND = 3;
    const SAME_USER = 4;
    const RELATION_ALREADY_EXISTS = 5;
    const RELATION_NOT_FOUND = 6;

    switch (error) {
        case SUCCESS:
            updateContacts();
            break;
        case EMPTY_INPUTS:
            errorDiv.append("empty inputs, ");
            break;
        case INVALID_EMAIL:
            errorDiv.append("incorrect email format, ");
            break;
        case USER_NOT_FOUND:
            errorDiv.append("user not found, ");
            break;
        case SAME_USER:
            errorDiv.append("your are this user, ");
            break;
        case RELATION_ALREADY_EXISTS:
            errorDiv.append("relation already exists, ");
            break;
        case RELATION_NOT_FOUND:
            errorDiv.append("relation not found, ");
            break;
        default:
            alert("Oops, something unexpected happened...");
            break;
    }
}

//-------------------------//
// Private Functions       //
//-------------------------//

function updateContacts() {
    $.post(FETCH_CONTACTS_URL, {email: loggedInUser.email}, (response) => {
        let contacts = JSON.parse(response);
        displayContacts(contacts);
    }, 'text');
}

function displayContacts(relations) {
    const contactsContainer = $('#contacts');

    contactsContainer.empty();

    relations.forEach((relation) => {
        const contactDiv = $('<div></div>');
        contactDiv.addClass('contact');
        contactDiv.html(relation.first_name + ' ' + relation.last_name);
        contactsContainer.append(contactDiv);
    })
}

function selectContact() {
    //TODO
    user.selectedContact = null;
}

function showAddFriendDialog() {
    const addFriendDialog = $('#add-friend');
    const requestMessage = $('#request-message');
    const closeButton = $('#close-button');

    addFriendDialog[0].showModal();

    requestMessage.on("input", () => {
        resizeDialog();
    });
    closeButton.on('click', () => {
        addFriendDialog[0].close();
    })
    window.addEventListener("resize", () => {
        resizeDialog(requestMessage[0]);
    });
}

function resizeDialog() {
    const textarea = $('#request-message')[0];

    textarea.style.height = 'auto';

    const currentScrollHeight = textarea.scrollHeight;
    const topPadding = parseInt(window.getComputedStyle(textarea).paddingTop);
    const bottomPadding = parseInt(window.getComputedStyle(textarea).paddingBottom);
    const verticalPadding = topPadding + bottomPadding;
    const finalHeight = currentScrollHeight - verticalPadding;

    textarea.style.height = finalHeight + 'px';
}
