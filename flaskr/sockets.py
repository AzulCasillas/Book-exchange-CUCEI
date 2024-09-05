from flask import (
    Blueprint, flash, g, redirect, render_template, request, session, url_for
)
from flask_socketio import SocketIO, Namespace, send, emit, join_room, leave_room
import pymysql.cursors

socketio = SocketIO()

class MyNamespace(Namespace):
    def on_connect(self):
        print('Client connected')

    def on_disconnect(self):
        print('Client disconnected')

    def on_joinChatRoom(self, data):
        print(data)
        join_room(data['room'])
        emit('join', { 'room': data['room'] })

    def on_leave(self, data):
        username = data['username']
        room = data['room']
        leave_room(room)
        send(username + ' has left the room.', to=room)

    def on_chat(self, data):
        print(data)
        recordMessage(data['room'], data['sender'], data['addresse'], data['message'])
        emit('chat', { 'message': data['message'], 'sender': data['sender'] }, to=data['room'], broadcast = True)

socketio.on_namespace(MyNamespace('/socket'))

def recordMessage(room, sender, addresse, message):
    connection = pymysql.connect(host='localhost',
                             user='root',
                             password='',
                             database='intlibros',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)
    try:
        with connection:
            with connection.cursor() as cursor:
                # Create a new record
                sql = "INSERT INTO mensajes (id_mensaje, id_sala, id_remitente, id_destinatario, mensaje) VALUES ('default', %s, %s, %s, %s)"
                cursor.execute(sql, (room, sender, addresse, message))

            # connection is not autocommit by default. So you must commit to save
            # your changes.
            connection.commit()
    except Exception as e:
        print(e)
