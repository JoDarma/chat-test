import { Conversation } from "./conversation.model";

export class Participation{

    constructor(
        id_utilisateur:number,
        id_conversation:number,
        created_at:string,
        updated_at:string
    ){}
}

export class ParticipationWithConversation extends Participation{
    conversation:Conversation[]
}