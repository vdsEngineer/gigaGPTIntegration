<?php

namespace VdsEngineer\GigaGptIntegration\Enum;

enum Urls: string
{
    case GET_ACCESS_TOKEN = 'https://ngw.devices.sberbank.ru:9443/api/v2/oauth';
    case CHAT_COMPLETIONS = 'https://gigachat.devices.sberbank.ru/api/v1/chat/completions';
    case MODEL_LIST = 'https://gigachat.devices.sberbank.ru/api/v1/models';
    case FILES_CONTENT = 'https://gigachat.devices.sberbank.ru/api/v1/files/%s/content';
    case TOKEN_COUNT = 'https://gigachat.devices.sberbank.ru/api/v1/tokens/count';
    case EMBEDDINGS = 'https://gigachat.devices.sberbank.ru/api/v1/embeddings';
}
