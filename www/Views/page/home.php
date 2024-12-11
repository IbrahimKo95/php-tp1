<?php

if (isset($_SESSION['user'])) {
    echo '<a href="/user/logout">Se déconnecter</a>';
} else {
    echo '<a href="/user/login">Se connecter</a>';
    echo  '<a href="/user/add">S\'inscrire</a>';
}