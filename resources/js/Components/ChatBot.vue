<template>
    <div class="fixed bottom-4 right-4 z-50 flex items-center justify-center">
      <Tooltip title="Preguntas frecuentes">
        <Button
          type="primary"
          shape="circle"
          size="large"
          danger
          @click="toggleChat"
        >
          <MessageOutlined />
        </Button>
      </Tooltip>
      <Drawer
        title="Chatbot"
        placement="right"
        :visible="visible"
        @close="toggleChat"
        width="400"
      >
        <!-- Contenedor de mensajes -->
        <div class="h-full flex flex-col justify-between">
          <div
            class="h-full flex-1 overflow-y-auto space-y-4"
            ref="messageContainer"
          >
            <!-- Mensajes predefinidos -->
            <div
              v-for="(faq, index) in faqs"
              :key="'faq-' + index"
              class="bg-gray-100 p-2 rounded-md"
            >
              <p class="font-semibold">{{ faq.question }}</p>
              <p class="text-sm text-gray-600">{{ faq.answer }}</p>
            </div>

            <!-- Mensajes del usuario -->
            <div
              v-for="(message, index) in userMessages"
              :key="'user-' + index"
              class="bg-blue-100 p-2 rounded-md text-blue-700"
            >
              <p class="font-semibold">Tú:</p>
              <p class="text-sm">{{ message }}</p>
            </div>

            <!-- Mensaje de respuesta por defecto -->
            <div
              v-if="responseMessage"
              class="bg-green-100 p-2 rounded-md text-green-700"
            >
              <p class="font-semibold">Chatbot:</p>
              <p class="text-sm">{{ responseMessage }}</p>
            </div>
          </div>

          <!-- Input y botón -->
          <div class="flex items-center space-x-2 mt-4">
            <Input
              v-model:value="userInput"
              placeholder="Escribe tu mensaje..."
              class="flex-1"
            />
            <Button type="primary" @click="sendMessage">Enviar</Button>
          </div>
        </div>
      </Drawer>
    </div>
  </template>

  <script setup>
  import { ref, nextTick } from "vue";
  import { Button, Tooltip, Drawer, Input } from "ant-design-vue";
  import { MessageOutlined } from "@ant-design/icons-vue";

  const visible = ref(false);
  const userInput = ref("");
  const userMessages = ref([]);
  const messageContainer = ref(null);
  const responseMessage = ref(""); // Mensaje de respuesta por defecto
  let hasReplied = false; // Controla si ya se envió la respuesta por defecto

  const toggleChat = () => {
    visible.value = !visible.value;
  };

  // Preguntas frecuentes
  const faqs = [
    {
      question: "¿Cómo registro una denuncia?",
      answer: "En el menú principal, selecciona 'Registrar denuncia'.",
    },
    {
      question: "¿Puedo editar mi denuncia?",
      answer: "Sí, en el apartado de denuncias puedes editar las que estén en proceso.",
    },
    {
      question: "¿Cómo contacto al soporte?",
      answer: "Envía un correo a soporte@ejemplo.com.",
    },
  ];

  // Simula el envío de un mensaje
  const sendMessage = async () => {
    console.log("Mensaje enviado:", userInput.value.trim());
    if (userInput.value.trim()) {
      userMessages.value.push(userInput.value.trim()); // Agrega el mensaje a la lista
      userInput.value = ""; // Limpia el campo de entrada

      // Enviar respuesta por defecto si es el primer mensaje
      if (!hasReplied) {
        hasReplied = true;
        responseMessage.value = "Hola, ¿En qué puedo ayudarte?";
      }

      // Desplaza el contenedor al final después de agregar el mensaje
      await nextTick();
      if (messageContainer.value) {
        messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
      }
    }
  };
  </script>
