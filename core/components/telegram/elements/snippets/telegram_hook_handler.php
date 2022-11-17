<?php
/** @var \TelegramManager\Hook $Hook */
/** @var TelegramBot $Bot */

/*
 * $Hook->command(); - команда
 * $Hook->query(); - текст после комманды
 * $Hook->getProperties(); - весь post запрос от telegram
 * $Hook->user(); - объект пользователя telegram отправившего запрос
 *      - $Hook->user()->typing(); // Имитирует "Печатает...."
 * */

// Отправляет сообщение пользователю
$Hook->user()->message('Привет, я прислал сообщение из сниппета');
