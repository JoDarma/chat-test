import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { NgbActiveModal } from '@ng-bootstrap/ng-bootstrap';
import { Utilisateur } from '../models/utilisateur.model';
import { ConvService } from '../service/conv.service';
import { UtilisateurService } from '../service/utilisateur.service';

@Component({
  selector: 'app-utilisateur-list-modal',
  templateUrl: './utilisateur-list-modal.component.html',
  styleUrls: ['./utilisateur-list-modal.component.scss']
})
export class UtilisateurListModalComponent implements OnInit {
  @Output() passEntry: EventEmitter<any> = new EventEmitter();

  type:string;

  currentUser:number;

  utilisateurList:Utilisateur[]=[]

  participant:number[]=[]

  constructor(
    private utilisateurService:UtilisateurService,
    private conversationService:ConvService,
    public activeModal: NgbActiveModal,
  ) { }

  ngOnInit(): void {

    console.log(this.type)
    this.getUtilisateur()
  }

  getUtilisateur(){
    this.utilisateurService.getUtilisateurs(this.currentUser).subscribe(
      (resp)=>{
        console.log(resp)
        this.utilisateurList = resp
      }
    )
  }

  creerConversation(libelle:string,userId?){
    if(userId){
      this.participant.push(userId)
    }
    this.participant.push(this.currentUser)
    
    this.conversationService.creerConv(this.participant,this.type, userId).subscribe(
      (resp)=>{
        this.participant=[]
        this.passEntry.emit(true);

        this.activeModal.close()
      },
      ()=>{

      }
    )
  }

  addParticipants(partId){
    this.participant.push(partId)
  }

  addPart(idUser){
   this.participant.push(idUser)

   console.log(this.participant)
  }

}
