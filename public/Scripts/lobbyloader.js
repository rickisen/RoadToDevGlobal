$(document).ready(function(){

  function refreshSearch(){
    $('body').load('/?/LobbyLoader/searchLobby', function(){
      setTimeout(refreshSearch, 5000);
  })};

  refreshSearch();

});
