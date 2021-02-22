import { Message } from "./message.model";

export class Conversation{
    constructor(
        id_conversation:number,
        libelle:string,
        type_conversation:string,
        created_at:string,
        updated_at:string,
        created_by:string
    ){}
}

export class ConversationWithMessage extends Conversation{
  
    constructor(
        messages:Message[]
    ){
        super(0,'','','','','')
    }
}