import { Component, OnInit } from '@angular/core';
import { JwtHelperService } from '@auth0/angular-jwt';
import { ConversationWithMessage } from '../models/conversation.model';
import { CustomResponse } from '../models/customResponse.model';
import { ParticipationWithConversation } from '../models/participation.model';
import { ConvService } from '../service/conv.service';
import {NgbModal, NgbModalOptions} from '@ng-bootstrap/ng-bootstrap';
import { UtilisateurListModalComponent } from '../utilisateur-list-modal/utilisateur-list-modal.component';
import { Subscription } from 'rxjs';
import { AuthService } from '../service/auth.service';

const helper = new JwtHelperService();

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  convList:ParticipationWithConversation[]=[]

  convMessage:any

  currentUser:number=0;

  messageToSend:string=""

  modalOptions: NgbModalOptions

  constructor(private convService:ConvService,private modalService : NgbModal, private authService:AuthService) { }

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
        console.log(this.convList)
      }
    )
  }

  getConvMessage(idConv){
    console.log(idConv)
    this.convService.getConvMessage(idConv).subscribe(
      (resp)=>{
        this.convMessage= resp[0]

        console.log(resp[0])
      }
    )
  }

  sendMessage(idConv){
    console.log(idConv);
    this.convService.envoyerMess(this.messageToSend, this.currentUser, idConv).subscribe(
      (resp)=>{
        console.log(this.convMessage)
        this.messageToSend=''
        // this.convMessage = resp
      }
    )
  }

  onWiewUser(type:string){
    this.modalOptions = {
      backdrop:true,
      backdropClass: 'light-blue-backdrop',
      centered:true
    }

    const modalRef = this.modalService.open(UtilisateurListModalComponent, this.modalOptions);
 
    modalRef.componentInstance.type = type;
    modalRef.componentInstance.currentUser = this.currentUser;


    modalRef.componentInstance.passEntry.subscribe(
      (receivedEntry) => {
        this.getConv()      
    })
  }

  logout(){
    this.authService.logout()
  }
}
