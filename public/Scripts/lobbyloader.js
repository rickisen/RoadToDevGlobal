$(document).ready(function(){

  function refreshSearch(){
    $('body').load('/?/LobbyLoader/lookForLobby', function(){
      setTimeout(refreshSearch, 5000);
  })};

  refreshSearch();

});
