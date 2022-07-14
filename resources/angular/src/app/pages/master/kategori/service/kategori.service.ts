import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
    providedIn: 'root'
})
export class KategoriService {

    constructor(private landaServ: LandaService) { }

    getKategoris(arrParameter) {
        return this.landaServ.DataGet('/v1/book-category', { arrParameter });
    }

    getKategoriById(kategoriId) {
        return this.landaServ.DataGet('/v1/book-category/' + kategoriId);
    }

    createKategori(payload) {
        return this.landaServ.DataPost('/v1/book-category', payload);
    }

    updateKategori(payload) {
        return this.landaServ.DataPut('/v1/book-category', payload);
    }

    deleteKategori(kategoriId) {
        return this.landaServ.DataDelete('/v1/book-category/' + kategoriId);
    }


}
