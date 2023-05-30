// Insert in "user-info" div the first name and the last name of the user
export function insertUserInfo(user) {
    $("#user-info").text(user["s_FirstName"] + " " + user["s_LastName"]);
}