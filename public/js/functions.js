function cleanUpSpecialChars(str)
{
    str = str.replace(/[àá]/g,"a");
    str = str.replace(/[èé]/g,"e");
    str = str.replace(/[ìí]/g,"i");
    str = str.replace(/[òó]/g,"o");
    str = str.replace(/[ùú]/g,"u");
    str = str.replace(/[ñ]/g,"n");
    // return str.replace(/[^a-z0-9]/gi,''); // final clean up
    return str;
}