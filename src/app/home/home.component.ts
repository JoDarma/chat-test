import { Component, OnInit } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import { ConversationWithMessage } from '../models/conversation.model';
import { CustomResponse } from '../models/customResponse.model';
import { ParticipationWithConversation } from '../models/participation.model';
import { ConvService } from '../service/conv.service';

const helper = new JwtHelperService();

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  convList:ParticipationWithConversation[]=[]

  convMessage:ConversationWithMessage[]=[]

  currentUser:number=0;

  messageToSend:string="toto"

  constructor(private convService:ConvService) { }

  ngOnInit(): void {
    this.getConv()

  }

  getConv(){
    let decodedToken = helper.decodeToken(localStorage.getItem('token'));
    this.currentUser = decodedToken.jti.id;
    console.log(decodedToken)
 
    this.convService.getConv(decodedToken.jti.id).subscribe(
      (resp:any)=>{
        this.convList= resp
      }
    )

  }

  getConvMessage(idConv){
    console.log(idConv)
    this.convService.getConvMessage(idConv).subscribe(
      (resp)=>{
        this.convMessage= resp
        console.log(this.convMessage)
      }
    )
  }

  sendMessage(idConv){
    console.log(idConv);
    this.convService.envoyerMess(this.messageToSend, this.currentUser, idConv).subscribe(
      (resp)=>{
        console.log(resp)
        this.convMessage = resp
      }
    )
  }
}
